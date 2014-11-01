<?php
/*
 * PHP code protect
 *
 * @link 		https://github.com/Mofsy/pcp-cs
 * @author		Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright	Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */


@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', false );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

include_once('server.class.php');

/*
 * Создаем экземпляр класса сервера
 */
$server = new ProtectServer($db_host, $db_user, $db_pass, $db_name);


$date = time();






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