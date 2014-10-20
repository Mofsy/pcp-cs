<?php
/*
=====================================================
 Файл: license_check.php
-----------------------------------------------------
 Назначение: Проверка валидности и активация лицензии
=====================================================
*/

@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', false );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

$date = time();


/*
 * Функция генерации локального ключа
 * @param string $license_key лицензионный ключ
 * @param string $domain доменное имя, на котором активирована лицензия
 * @param 
 * @param 
 * @param 
 */

function create_local_key($license_user_id, $license_user_name, $license_key, $domain, $ip, $directory, $server_hostname, $server_ip, $license_method_id, $license_expires, $license_status, $license_wildcard)
{
	global $db;

	/*
	  * Запрашиваем все необходимое о методе из базы данных по полученному ID
	  */
	$method_result = $db->query("SELECT * FROM " . PREFIX . "_clients_license_methods WHERE id='{$license_method_id}'");
	$method_row = $db->get_row($method_result);
	/*
	  Секретный ключ метода */
	$secret_key = $method_row['secret_key'];
	/*
	  Маркер того, что проверять */
	$enforce = explode("|",$method_row['enforce']);
	/*
	  Период проверки локального ключа в днях */
	$check_period = $method_row['check_period'];

	/*
	  Массив с указателями проверки
	  Можно проверять домен, айпи адрес, имя хоста */
	$instance = array();

	$instance['domain'] =  array (0 => "$domain", 1 => "www.$domain");

	/*
	  Массив со всеми необходимым данными лицензии */
	$key_data = array();
	/*
	  Уникальный идентификатор клиента */
	$key_data['customer'] = $license_user_id;
	/*
	  Уникальный логин клиента на сайте */
	$key_data['user'] = $license_user_name;
	/*
	  Лицензионный ключ */
	$key_data['license_key_string'] = $license_key;
	/*
	  Данные о том, что следует проверять */
	$key_data['instance'] = $instance;
	/*
	  Маркер проверки, указывает на то, что надо проверять в данных */
	$key_data['enforce'] = 'domain';
	/*
	  Кастомные поля, не учитываются */
	$key_data['custom_fields'] = array();
	/*
	  Время истечения срока скачивания модуля */
	$key_data['download_access_expires'] = 0;
	/*
	  Время истечения срока поддержки */
	$key_data['support_access_expires'] = 0;
	/*
	   Дата окончания лицензии в Unix-времени */
	$key_data['license_expires'] = $license_expires;
	/*
	  Время истечения локального ключа
	  берем количество дней из метода, умножаем его на количество секунд в сутках и прибавляем к Unix-времени. */
	$key_data['local_key_expires'] = ((integer)$check_period * 86400) + time();
	/*
	  Статус лицензии, если вернуть другой, то лицензия перестанет работать */
	if ($license_status == 0 || $license_status == 1 || $license_status == 3)
		$status = 'Active';

	$key_data['status'] = strtolower( $status );

	/*
	  Сериализуем все данные лицензии */
	$key_data = serialize( $key_data );

	/*
	  Конечная обработка всех данных */
	$license_info = array();
	$license_info[0] = $key_data;
	$license_info[1] = md5($secret_key.$license_info[0]);
	$license_info[2] = md5( microtime() );

	$license_info = base64_encode(implode( "{protect}", $license_info ));

	return urlencode( wordwrap( $license_info, 64, "\n", 1 ) );
}



/*
** Проверяем пост запрос от клиента лицензии
*/
if($_POST['license_key']) {

	/*
	   Лицензионный ключ активации */
	$key = $db->safesql( htmlspecialchars( trim( strip_tags(strval( $_POST['license_key'] ) ) ) ));

	/*
	   Домен на котором установлен клиент */
	$domain = $db->safesql( htmlspecialchars( trim( strip_tags(strval( $_POST['domain'])))));
	$domain = str_replace("www.","",$domain);

	/*
	   Айпи адрес клиента */
	$ip = $_POST['ip'];

	/*
	   Директория до root где установлен клиент */
	$directory = $db->safesql( htmlspecialchars( trim( strip_tags(strval( $_POST['directory'])))));

	/*
	   Имя хоста где установлен лиент */
	$server_hostname = $db->safesql( htmlspecialchars( trim( strip_tags(strval( $_POST['server_hostname'])))));

	/*
	   Айпи адрес сервера где установлен клиент */
	$server_ip = $db->safesql( htmlspecialchars( trim( strip_tags($_POST['server_ip']))));


	/*
	   Запрашиваем все данные о лицензионном ключе из базы данных */
	$result = $db->query("SELECT * FROM " . PREFIX . "_clients_license WHERE l_key='$key' LIMIT 0,1");
	$row = $db->get_row($result);

	/*
	   Если отсутствует в базе такой лицензионный ключ активации */
	if (count($row) < 1) {
		// заносим попытку в базу и все пришедшие данные
		$db->query( "INSERT INTO " . PREFIX . "_clients_license_logs SET `l_status` = 'Invalid', `date` = '$date', `l_key` = '$key', `l_id` = '', `l_domain` = '$domain', `l_ip` = '$ip', `l_directory` = '$directory', `l_server_hostname` = '$server_hostname', `l_server_ip` = '$server_ip', `l_method_id`  = ''" );
		// выдаем то, что ключ не валиден.
		die("Invalid");
	}

	/*
	** Данные полученные из базы данных
	*/
	/*
	   Идентификатор лицензионного ключа */
	$license_id = $row['id'];
	/*
	   Лицензионный ключ активации */
	$license_key = $row['l_key'];
	/*
	   Идентификатор клиента на сайте */
	$license_user_id = $row['user_id'];
	/*
	   Логин клиента на сайте */
	$license_user_name = $row['user_name'];
	/*
	   Доменное имя лицензии, если она была активирована */
	$license_domain = $row['l_domain'];
	$license_wildcard = $row['l_domain_wildcard'];
	/*
	   Айпи адрес сервера */
	$license_ip = $row['l_ip'];
	/*
	   Директория при активации */
	$license_directory = $row['l_directory'];
	/*
	   Название хоста при активации */
	$license_server_hostname = $row['l_server_hostname'];
	/*
	   Айпи адрес хоста при активации */
	$license_server_ip = $row['l_server_ip'];
	/*
	   Статус лицензии:
	   0 - не активирована
	   1 - лицензия активирована
	   2 - срок истек
	   3 - лицензия переиздана (сделано продление) */
	$license_status = $row['l_status'];
	/*
	   Метод проверкилицензионного ключа */
	$license_method_id = $row['l_method_id'];
	/*
	   Дата истечения срока действия лицензионного ключа в UNIX формате */
	$license_expires = $row['l_expires'];

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

?>