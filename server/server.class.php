<?php
/*
 * PHP code protect
 *
 * @link 		https://github.com/Mofsy/pcp-cs
 * @author		Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright	Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */

class ProtectServer {

	/*
	 * Префикс таблиц базы данных
	 *
	 * @var string
	 */
	public $db_prefix = '';

	/*
	 * Объект базы данных
	 */
	public $db;


	/*
	 * Конструктор класса
	 */
	public function __construct($db_host, $db_user, $db_pass, $db_name, $db_prefix)
	{
		include_once('database.class.php');
		$this->db = new Db($db_user, $db_pass, $db_name, $db_host);
	}

	/*
	 * Деструктор класа
	 */
	public function __destruct()
	{
		$this->db->close();
	}

	/*
	 *
	 */
	public function run()
	{


		/*
		** Проверяем пост запрос от клиента лицензии
		*/
		if($_POST['license_key']) {

			/*
			   Если отсутствует в базе такой лицензионный ключ активации */
			if (count($row) < 1) {
				// заносим попытку в базу и все пришедшие данные
				$db->query( "INSERT INTO " . PREFIX . "_clients_license_logs SET `l_status` = 'Invalid', `date` = '$date', `l_key` = '$key', `l_id` = '', `l_domain` = '$domain', `l_ip` = '$ip', `l_directory` = '$directory', `l_server_hostname` = '$server_hostname', `l_server_ip` = '$server_ip', `l_method_id`  = ''" );
				// выдаем то, что ключ не валиден.
				die("Invalid");
			}

			/*
			   Определяем статус лицензии для лога */
			if ($license_status == 0 || $license_status == 1 || $license_status == 3)
				$status = 'Active';
			else
				$status = 'Invalid';

			/*
			   Заносм обращение в лог */
			$db->query( "INSERT INTO " . PREFIX . "_clients_license_logs SET `l_status` = '$status', `date` = '$date', `l_key` = '$key', `l_id` = '$license_id', `l_domain` = '$domain', `l_ip` = '$ip', `l_directory` = '$directory', `l_server_hostname` = '$server_hostname', `l_server_ip` = '$server_ip', `l_method_id`  = '$license_method_id'" );


			//Если у продукта статус 0 или 3, т.е. неактивирован, то заносим все данные в базу, меняем статус и генерируем локальный ключ
			if ($license_status == 0 || $license_status == 3)
			{
				//Заносим в базу данные и меняем статус
				$db->query( "UPDATE " . PREFIX . "_clients_license SET l_domain='$domain', l_ip='$ip', l_directory='$directory', l_server_hostname='$server_hostname', l_server_ip = '$server_ip', l_status='1', l_last_check='$date' WHERE id='$license_id'" );

				$localkey = create_local_key($license_user_id, $license_user_name, $license_key, $domain, $ip, $directory, $server_hostname, $server_ip, $license_method_id, $license_expires, $license_status, $license_wildcard);

				echo $localkey;
			}

			// Если лицензия продукта уже была активирована
			if ($license_status == 1)
			{
				/*
				* Проверяем пришедший домен и принадлежность к доступным поддоменам.
				*/
				// если пришедший домен не равен домену из базы, и включены поддомены для лицензии,
				// то проверяем принадлежность домена к поддоменам и назначаем поддомен в домен если пришел запрос с поддомена активной лицензии
				$pos = dle_strrpos($domain, $license_domain, $config['charset'] );
				if($domain != $license_domain && $license_wildcard == 1 && $pos !== false) {
					$license_domain = $domain;
				}

				if ($license_domain != $domain) {die('Invalid');}


				$localkey = create_local_key($license_user_id, $license_user_name, $license_key, $domain, $ip, $directory, $server_hostname, $server_ip, $license_method_id, $license_expires, $license_status, $license_wildcard);

				echo $localkey;

				$db->query( "UPDATE " . PREFIX . "_clients_license  SET l_last_check='$date' WHERE id='$license_id'" );
			}

		}
	}

	/*
	 * Генерация локального ключа
	 *
	 * @param string $license_key лицензионный ключ
	 * @param string $domain доменное имя, на котором активирована лицензия
	 */

	public function localKeyCreate($license_key)
	{
		/*
		 * Запрашиваем все данные о лицензионном ключе из базы данных по ключу
		 */
		$key_data = $this->licenseKeyGet($license_key);

		/*
		 * Запрашиваем все необходимое о методе из базы данных по полученному ID
		 */
		$method_data = $this->licenseKeyMethodGet($key_data['method_id']);


		/*
		 * Массив с указателями проверки
		 * Можно проверять домен, айпи адрес, имя хоста
		 */
		$instance = array();

		$instance['domain'] = array(0 => "$domain", 1 => "www.$domain");

		/*
		 * Уникальный идентификатор клиента
		 */
		$key_data['customer'] = $license_user_id;

		/*
		 * Уникальный логин клиента на сайте
		 */
		$key_data['user'] = $license_user_name;

		/*
		 * Лицензионный ключ
		 */
		$key_data['license_key_string'] = $license_key;

		/*
		 * Данные о том, что следует проверять
		 */
		$key_data['instance'] = $instance;

		/*
		 * Маркер проверки, указывает на то, что надо проверять в данных
		 */
		$key_data['enforce'] = $enforce;

		/*
		 * Кастомные поля, не учитываются
		 */
		$key_data['custom_fields'] = array();

		/*
		 * Время истечения срока скачивания модуля
		 */
		$key_data['download_access_expires'] = 0;

		/*
		 * Время истечения срока поддержки
		 */
		$key_data['support_access_expires'] = 0;

		/*
		 * Дата окончания лицензии в Unix-времени
		 */
		$key_data['license_expires'] = $license_expires;

		/*
		 * Время истечения локального ключа
		 * берем количество дней из метода, умножаем его на количество секунд в сутках и прибавляем к Unix-времени.
		 */
		$key_data['local_key_expires'] = ((integer)$check_period * 86400) + time();

		/*
		 * Статус лицензии, если вернуть другой, то лицензия перестанет работать
		 */
		if ($license_status == 0 || $license_status == 1 || $license_status == 3)
			$status = 'Active';

		$key_data['status'] = strtolower($status);

		/*
		 * Сериализуем все данные лицензии
		 */
		$key_data = serialize($key_data);

		/*
		 * Конечная обработка всех данных
		 */
		$license_info = array();
		$license_info[0] = $key_data;
		$license_info[1] = md5($secret_key.$license_info[0]);
		$license_info[2] = md5( microtime() );
		$license_info = base64_encode(implode( "{protect}", $license_info ));

		return urlencode( wordwrap( $license_info, 64, "\n", 1 ) );
	}

	/*
	 * Создание лицензионного ключа
	 *
	 * @return string 25 значный ключ активации (5 пар по 5)
	 */
	public function licenseKeyCreate()
	{
		$key = md5(mktime());
		$new_key = '';
		for ($i = 1; $i <= 25; $i++)
		{
			$new_key .= $key[$i];
			if ($i % 5 == 0 && $i != 25) $new_key .= '-';
		}

		return strtoupper($new_key);
	}

	/*
	 * Получение информации о методе проверки лицензионного ключа по id
	 *
	 * @param integer $license_key_method_id Идентификатор метода проверки лицензионного ключа
	 * @return array|boolean Массив с информацией о методе, либо false при отсутствие метода
	 */
	public function licenseKeyMethodGet($license_key_method_id)
	{
		$method_data = array();

		$result = $this->db->query("SELECT * FROM " . $this->db_prefix . "_license_methods WHERE id='{$license_key_method_id}'");
		$row = $this->db->get_row($result);

		/*
		 * Секретный ключ метода
		 */
		$method_data['secret_key'] = $row['secret_key'];

		/*
		 * Маркер того, что проверять
		 */
		$method_data['enforce'] = explode(",", $row['enforce']);

		/*
		 * Период проверки локального ключа в днях
		 */
		$method_data['check_period'] = $row['check_period'];

		return $method_data;
	}

	/*
	 * Получение всей информации о лицензионном ключе по ключу
	 *
	 * @return array|boolean Массив с информацией о ключе, либо false при отсутствие метода
	 */
	public function licenseKeyGet($key)
	{
		$key_data = array();

		$result = $this->db->query("SELECT * FROM " . $this->db_prefix . "_license_keys WHERE l_key='$key' LIMIT 0,1");
		$row = $this->db->get_row($result);

		/*
		 * Идентификатор лицензионного ключа
		 */
		$key_data['id'] = $row['id'];

		/*
		 * Лицензионный ключ активации
		 */
		$key_data['key'] = $row['l_key'];

		/*
		 * Идентификатор клиента на сайте
		 */
		$key_data['user_id'] = $row['user_id'];

		/*
		 * Логин клиента на сайте
		 */
		$key_data['user_name'] = $row['user_name'];

		/*
		 * Доменное имя лицензии, если она была активирована
		 */
		$key_data['domain'] = $row['l_domain'];

		/*
		 * Разрешено ли использовать на поддоменах
		 *
		 * 1 - разрешено
		 * 0 - запрещено
		 */
		$key_data['domain_wildcard'] = $row['l_domain_wildcard'];

		/*
		 * Айпи адрес сервера
		 */
		$key_data['ip'] = $row['l_ip'];

		/*
		 * Директория где находится клиент
		 */
		$key_data['directory'] = $row['l_directory'];

		/*
		 * Название хоста где находится клиент
		 */
		$key_data['server_hostname'] = $row['l_server_hostname'];

		/*
		 * Айпи адрес хоста где находится клиент
		 */
		$key_data['server_ip'] = $row['l_server_ip'];

		/*
		 * Статус лицензии
		 *
		 * 0 - не активирована
		 * 1 - лицензия активирована
		 * 2 - срок истек
		 * 3 - лицензия переиздана (сделано продление)
		 */
		$key_data['status'] = $row['l_status'];

		/*
		 * Метод проверки лицензионного ключа
		 */
		$key_data['method_id'] = $row['l_method_id'];

		/*
		 * Дата истечения срока действия лицензионного ключа в UNIX формате
		 */
		$key_data['expires'] = $row['l_expires'];

		return $key_data;
	}

	/*
	 * Получение данных пришедших от клиента
	 *
	 * @return array
	 */
	public function clientDataGet()
	{
		$client_data = array();

		/*
		 * Проверяем наличие пост запроса от клиента
		 */
		if ($_POST['license_key'])
		{
			/*
	   		 * Лицензионный ключ активации
			 */
			$client_data['key'] = $this->db->filter(htmlspecialchars(trim(strip_tags(strval($_POST['license_key'])))));

			/*
			 * Домен на котором установлен клиент (без www)
			 */
			$client_data['domain'] = $this->db->filter(htmlspecialchars(trim(strip_tags(strval($_POST['domain'])))));
			$client_data['domain'] = str_replace("www.", "", $client_data['domain']);

			/*
			 * Айпи адрес клиента
			 */
			$client_data['ip'] = $_POST['ip'];

			/*
			 * Директория от root где установлен клиент
			 */
			$client_data['directory'] = $this->db->filter(htmlspecialchars(trim(strip_tags(strval($_POST['directory'])))));

			/*
			 * Имя хоста где установлен лиент
			 */
			$client_data['server_hostname'] = $this->db->filter(htmlspecialchars(trim(strip_tags(strval($_POST['server_hostname'])))));

			/*
			 * Айпи адрес сервера где установлен клиент
			 */
			$client_data['server_ip'] = $this->db->filter(htmlspecialchars(trim(strip_tags($_POST['server_ip']))));

		}

		return $client_data;
	}
} 