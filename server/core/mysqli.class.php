<?php
/**
 * PHP code protect
 *
 * @link          https://github.com/Mofsy/pcp-cs
 * @author        Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright     Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */

namespace Mofsy\License\Server\Core;

class Mysqli
{
    /*
     * Конфигурация подключения
     */
    private $config = array();

    /*
     * Идентификатор подключения к базе
     */
    public $id = false;

    /*
     * Идентификатор запроса
     */
    public $query_id = false;

    /*
     * Количество выполненных запросов
     */
    public $query_num = 0;

    /*
     * Массив выполненных запросов
     */
    public $query_list = array();

    /*
     * Последняя ошибка
     */
    public $error = '';

    /*
     * Число ошибок
     */
    public $error_num = 0;

    /*
     * Версия Mysql сервера
     */
    public $mysql_version = '';

    /*
     * Кодировка
     */
    public $collate = 'utf8';

    /*
     * Конструктор класса
     */
    public function __construct($db_user, $db_pass, $db_name, $db_location = 'localhost', $show_error = 0)
    {
        $this->config['user'] = $db_user;
        $this->config['pass'] = $db_pass;
        $this->config['name'] = $db_name;
        $this->config['location'] = $db_location;
        $this->config['show_error'] = $show_error;
        return true;
    }

    /*
     * Создание нового подключения к базе
     */
    private function connect(){

        $this->id = mysqli_connect($this->config['location'], $this->config['user'],  $this->config['pass'], $this->config['name']);

        if (!$this->id) {
            if ($this->config['show_error'] == 1) {
                $this->display_error(mysqli_connect_error(), '1', 'connect');
            } else {
                return false;
            }
        }

        $this->mysql_version = mysqli_get_server_info($this->id);
        mysqli_query($this->id, "SET NAMES '" . $this->collate . "'");
    }

    /*
     * выполняем запрос
     */
    public function query($query, $show_error = true)
    {
        if(!$this->id) $this->connect();

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

    /*
     * Номер последней добавленной записи
     */
    public function insert_id()
    {
        return mysqli_insert_id($this->id);
    }

    public function get_result_fields($query_id = '')
    {

        if ($query_id == '') $query_id = $this->query_id;

        $fields = array();

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

        mysqli_free_result($query_id);
    }

    /*
     * Закрываем соединение
     */
    public function close()
    {
        mysqli_close($this->id);
        $this->id = false;
    }

    /*
     * Деструктор
     */
    public function __destruct()
    {
        // Закрываем открытое соединение
        if($this->id)
            mysqli_close($this->id);
    }

    /*
     * Вывод ошибок
     */
    public function display_error($error, $error_num, $query = '')
    {
        echo <<<HTML
			Error ($error_num):<br /> <b>{$error}</b><br /><br />
			<b>SQL query:</b><br /><br />{$query}
HTML;

        die();
    }

}

?>