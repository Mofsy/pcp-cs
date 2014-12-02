<?php
/**
 * PHP code protect
 *
 * @link          https://github.com/Mofsy/pcp-cs
 * @author        Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright     Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */

namespace Mofsy\License\Server\Core;

class Auth
{
    /**
     * Маркер авторизации пользователя
     *
     * @var boolean
     */
    public $user_logged = false;

    /**
     * Текущий идентификатор пользователя
     *
     * @var integer
     */
    public $user_id = 0;

    /**
     * Текущий логин пользователя
     */
    public $user_name = '';

    /**
     * Текущий айпи адрес пользователя
     *
     * @var string
     */
    public $user_ip = '';

    /**
     * Объект базы данных
     *
     * @var object
     */
    private $db;

    /*
     * Конструктор класса
     */
    public function __construct($config)
    {
        $this->user_ip = $this->getIp();
        $this->db_prefix = $config['db_prefix'];
        $this->db = new Mysqli($config['db_user'],$config['db_pass'], $config['db_name'], $config['db_host']);
        $this->autoLogin();
    }

    /*
     * автоматический вход
     */
    public function autoLogin()
    {
        if( isset( $_SESSION['pcp_user_id'] ) AND  intval( $_SESSION['pcp_user_id'] ) > 0 AND $_SESSION['pcp_password'] )
        {
            $this->login($_SESSION['pcp_user_name'], $_SESSION['pcp_password'], false, true);
        }
        elseif( isset( $_COOKIE['pcp_user_id'] ) AND intval( $_COOKIE['pcp_user_id'] ) > 0 AND $_COOKIE['pcp_password'])
        {
            $this->login($_COOKIE['pcp_user_name'], $_COOKIE['pcp_password'], true, true);
        }
        return false;
    }

    /*
     * Вход
     */
    public function login($user, $password, $remember = false, $auto = false)
    {
        $user = $this->db->filter($user);

        if(!$auto)
            $password = @md5($password);

        $user = $this->db->super_query( "SELECT * FROM " . $this->db_prefix . "_users WHERE name='{$user}'" );

        if( $user['user_id'] AND $user['password'] AND $user['password'] == md5( $password ) ) {

            if(!$auto)
            {
                session_regenerate_id();

                if ($remember) {
                    $this->setCookie( "pcp_user_id", "", 0 );
                    $this->setCookie( "pcp_password", "", 0 );
                    $this->setCookie( "pcp_user_name", "", 0 );
                } else {
                    $this->setCookie( "pcp_user_id", $user['user_id'], 365 );
                    $this->setCookie( "pcp_user_name", $user['name'], 365 );
                    $this->setCookie( "pcp_password", $password, 365 );
                }

                $_SESSION['pcp_user_id'] = $user['user_id'];
                $_SESSION['pcp_user_name'] = $user['name'];
                $_SESSION['pcp_password'] = $password;
            }

            $this->user_logged = true;
            $this->user_name = $user['name'];

            return true;
        }
        return false;
    }

    /*
     * Выход
     */
    public function logout()
    {
        $this->setCookie( "pcp_user_id", "", 0 );
        $this->setCookie( "pcp_user_name", "", 0 );
        $this->setCookie( "pcp_password", "", 0 );
        $this->setCookie( session_name(), "", 0 );
        @session_destroy();
        @session_unset();
    }

    /**
     * Айпи адрес
     *
     * @return string
     */
    public function getIp()
    {
        $ip = '';

        if ($_SERVER['HTTP_CLIENT_IP'])
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ip = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ip = $_SERVER['REMOTE_ADDR'];

        return $ip;
    }

    /*
     * Cookie
     */
    function setCookie($name, $value, $expires) {

        if( $expires )
        {
            $expires = time() + ($expires * 86400);
        }
        else
        {
            $expires = FALSE;
        }

        setcookie( $name, $value, $expires, "/", $_SERVER['HTTP_HOST'], NULL, TRUE );
    }

}