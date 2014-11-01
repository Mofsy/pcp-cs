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

/*
 * Конфигурация подключения к базе данных
 */
$db_host = 'localhost';
$db_user = 'test';
$db_pass = 'test';
$db_name = 'test';
$db_prefix = 'pcp';

include_once('server.class.php');

/*
 * Создаем экземпляр класса сервера
 */
$server = new ProtectServer($db_host, $db_user, $db_pass, $db_name, $db_prefix);

/*
 * Запускаем сервер
 */
$server->run();

