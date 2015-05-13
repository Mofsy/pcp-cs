<?php
/**
 * PHP code protect
 *
 * @link          https://github.com/Mofsy/pcp-cs
 * @author        Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright     Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */

include_once(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'server.class.php');
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'mysqli.class.php');
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'config.php');

/*
 * Создаем экземпляр класса сервера
 */
$server = new Mofsy\License\Server\Core\Protect($config);

/**
 * Добавляем метод проверки лицензионного ключа
 */
$method_data = $server->licenseKeyMethodCreate('Название метода', 'Секретный ключ', 'Период проверки в днях', 'Что проверять, например domain, ip');


/**
 * Создание нового лицензионного ключа активации
 */
$key_data = $server->licenseKeyCreate(234234234234, 1, 0);


/**
 * Смена статуса лицензионного ключа по ключу
 */
$server->licenseKeyStatusUpdateByKey('Лицензионный ключ', 'Новый статус');