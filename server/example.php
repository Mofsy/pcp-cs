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
$server = new ProtectServer($db_host, $db_user, $db_pass, $db_name, $db_prefix);

/*
 * Добавляем метод проверки лицензионного ключа
 *
 * TODO: Доработать
 */
$server->licenseKeyMethodCreate('Название метода', 'Секретный ключ', 'Период проверки в днях', 'Что проверять, например domain, ip');


/*
 * TODO: Добавить метод добавления лицензионных ключей.
 */

