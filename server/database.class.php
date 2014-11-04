<?php
/**
 * PHP code protect
 *
 * @link 		https://github.com/Mofsy/pcp-cs
 * @author		Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright	Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */

namespace Mofsy\License\Server;

class Db
{
	public $id = false;

	public $query_id = false;

	public $query_num = 0;

	public $query_list = array();

	public $error = '';

	public $error_num = 0;

	public $mysql_version = '';

	public $collate = 'utf8';


	public function __construct($db_user, $db_pass, $db_name, $db_location = 'localhost', $show_error = 0)
	{
		$db_location = explode(":", $db_location);

		if (isset($db_location[1])) {

			$this->id = @mysqli_connect($db_location[0], $db_user, $db_pass, $db_name, $db_location[1]);

		} else {

			$this->id = @mysqli_connect($db_location[0], $db_user, $db_pass, $db_name);

		}

		if (!$this->id) {
			if ($show_error == 1) {
				$this->display_error(mysqli_connect_error(), '1');
			} else {
				return false;
			}
		}

		$this->mysql_version = mysqli_get_server_info($this->id);

		mysqli_query($this->id, "SET NAMES '" . $this->collate . "'");

		return true;
	}

	public function query($query, $show_error = true)
	{
		if (!($this->query_id = mysqli_query($this->id, $query))) {

			$this->error = mysqli_error($this->id);
			$this->error_num = mysqli_errno($this->id);

			if ($show_error) {
				$this->display_error($this->error, $this->error_num, $query);
			}
		}
		$this->query_num++;

		return $this->query_id;
	}

	public function get_row($query_id = '')
	{
		if ($query_id == '') $query_id = $this->query_id;

		return mysqli_fetch_assoc($query_id);
	}

	public function get_affected_rows()
	{
		return mysqli_affected_rows($this->id);
	}

	public function get_array($query_id = '')
	{
		if ($query_id == '') $query_id = $this->query_id;

		return mysqli_fetch_array($query_id);
	}

	public function super_query($query, $multi = false)
	{

		if (!$multi) {

			$this->query($query);
			$data = $this->get_row();
			$this->free();

			return $data;

		} else {
			$this->query($query);

			$rows = array();
			while ($row = $this->get_row()) {
				$rows[] = $row;
			}

			$this->free();

			return $rows;
		}
	}

	public function num_rows($query_id = '')
	{
		if ($query_id == '') $query_id = $this->query_id;

		return mysqli_num_rows($query_id);
	}

	public function insert_id()
	{
		return mysqli_insert_id($this->id);
	}

	public function get_result_fields($query_id = '')
	{

		if ($query_id == '') $query_id = $this->query_id;

		while ($field = mysqli_fetch_field($query_id)) {
			$fields[] = $field;
		}

		return $fields;
	}

	public function filter($source)
	{
		if ($this->id) return mysqli_real_escape_string($this->id, $source);
		else return addslashes($source);
	}

	public function free($query_id = '')
	{

		if ($query_id == '') $query_id = $this->query_id;

		@mysqli_free_result($query_id);
	}

	public function close()
	{
		@mysqli_close($this->id);
	}

	public function display_error($error, $error_num, $query = '')
	{

		$query = htmlspecialchars($query, ENT_QUOTES, 'ISO-8859-1');
		$error = htmlspecialchars($error, ENT_QUOTES, 'ISO-8859-1');

		echo <<<HTML
			Error ($error_num):<br /> <b>{$error}</b><br /><br />
			<b>SQL query:</b><br /><br />{$query}
HTML;

		die();
	}

}

?>