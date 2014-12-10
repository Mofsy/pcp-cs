<?php
/**
 * PHP code protect
 *
 * @link          https://github.com/Mofsy/pcp-cs
 * @author        Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright     Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
@ini_set('display_errors', false);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE);

/*
 * Компоненты
 */
include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'server.class.php');
include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'mysqli.class.php');
include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php');

/*
 * Создаем экземпляр класса сервера
 */
$server = new Mofsy\License\Server\Core\Protect($config);

/*
 * Запускаем сервер
 */
$server->run();