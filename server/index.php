<?php
/**
 * PHP code protect
 *
 * @link          https://github.com/Mofsy/pcp-cs
 * @author        Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright     Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */
$time_start = microtime(true);

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
@ini_set('display_errors', true);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE);

@session_start();

/*
 * Компоненты
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'server.class.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'mysqli.class.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'auth.class.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php');
require_once(dirname(__FILE__) . '/vendor/twig/Autoloader.php');

/*
 * Шаблонизатор
 */
Twig_Autoloader::register(true);
$loader = new Twig_Loader_Filesystem(__DIR__ . '/template');
$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__ . '/cache',
    'auto_reload' => true
));

/*
 * Авторизация
 */
$auth = new \Mofsy\License\Server\Core\Auth($config);

/*
 * Создаем экземпляр класса сервера
 */
$server = new \Mofsy\License\Server\Core\Protect($config);


$data = array();
$data['home_url'] = $config['home_url'];
$data['user_ip'] = $auth->user_ip;

if( isset( $_REQUEST['action'] ) and $_REQUEST['action'] == "logout" )
{
    $auth->logout();
    header( "Location: " . $config['home_url'] . "/index.php");
    die();
}
if(isset($_POST['name']) && isset($_POST['password']))
{
    $auth->login($_POST['name'], $_POST['password'], $_POST['remember_me'], false);
}

if($auth->user_logged)
{

    $data['title'] = 'Control panel';
    $data['user_name'] = $auth->user_name;
	$module = 'main';

    if(isset($_GET['mod']))
    {
        $module = $_GET['mod'];
	}

    $data['module'] = $module;

    if($module === 'keys')
    {
        $data['keys'] = $server->getActivationKeys();
    }
    if($module === 'logs')
    {
        $data['logs'] = '';
    }

    echo $twig->render('index.html', $data);

}
else
{
    if(isset($_POST['name']) || isset($_POST['password']))
        $data['error'] = true;

    echo $twig->render('login.html', $data);
}

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "<!-- Выполнялось $time секунд!-->";