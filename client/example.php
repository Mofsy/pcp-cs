<?php
/**
 * PHP code protect
 *
 * @link 		https://github.com/Mofsy/pcp-cs
 * @author		Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright	Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */

include_once(dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'client.class.php');

/**
 * Создаем экземпляр класса
 */
$protect = new Mofsy\License\Client\Protect();

/**
 * Указываем директорию с правами на запись.
 * В эту директорию будет скачиваться файл локального ключа с сервера.
 */
$protect->local_key_path = './';

/**
 * Указываем название файла в котором будет храниться локальный ключ.
 */
$protect->local_key_name = 'license.lic';

/**
 * Указываем полный путь до сервера лицензий.
 */
$protect->server = 'http://localhost/server/server.php';

/**
 * Указываем ключ лицензии, например из конфигурации.
 */
$protect->license_key = 'WEFSZ-ERGER-GRGER-NGNFG-SDFSF';

/**
 * Указываем дату релиза скрипта
 */
$protect->release_date = '03.11.2014';

/**
 * Устанавливаем локализацию статусов и ошибок
 */
$protect->status_messages = array(
	'status_1'                       => '<span style="color:green;">Активна</span>',
	'status_2'                       => '<span style="color:darkblue;">Внимание</span>: срок действия лицензии закончился.',
	'status_3'                       => '<span style="color:orange;">Внимание</span>: лицензия переиздана. Ожидает повторной активации.',
	'status_4'                       => '<span style="color:red;">Ошибка</span>: лицензия была приостановлена.',
	'localhost'                      => '<span style="color:orange;">Активна на localhost</span>: используется локальный компьютер, на реальном сервере произойдет активация, если вы правильно ввели лицензионный ключ активации в настройках.',
	'pending'                        => '<span style="color:red;">Ошибка</span>: лицензия ожидает рассмотрения.',
	'download_access_expired'        => '<span style="color:red;">Ошибка</span>: ключ не подходит для установленной версии. Пожалуйста поставьте более старую версию продукта.',
	'missing_license_key'            => '<span style="color:red;">Ошибка</span>: лицензионный ключ не указан.',
	'unknown_local_key_type'         => '<span style="color:red;">Ошибка</span>: неизвестный тип проверки локального ключа.',
	'could_not_obtain_local_key'     => '<span style="color:red;">Ошибка</span>: невозможно получить новый локальный ключ.',
	'maximum_delay_period_expired'   => '<span style="color:red;">Ошибка</span>: льготный период локального ключа истек.',
	'local_key_tampering'            => '<span style="color:red;">Ошибка</span>: локальный лицензионный ключ поврежден или не действителен.',
	'local_key_invalid_for_location' => '<span style="color:red;">Ошибка</span>: локальный ключ не подходит к данному сайту.',
	'missing_license_file'           => '<span style="color:red;">Ошибка</span>: создайте следующий пустой файл и папки если их нету:<br />',
	'license_file_not_writable'      => '<span style="color:red;">Ошибка</span>: сделайте для записи следующие пути:<br />',
	'invalid_local_key_storage'      => '<span style="color:red;">Ошибка</span>: не возможно удалить старый локальный ключ.',
	'could_not_save_local_key'       => '<span style="color:red;">Ошибка</span>: не возможно записать новый локальный ключ.',
	'license_key_string_mismatch'    => '<span style="color:red;">Ошибка</span>: локальный ключ не действителен для указанной лицензии.',
);


/**
 * Запускаем валидацию
 */
$protect->validate();

/**
 * Если истина, то лицензия в боевом состоянии
 */
if($protect->status)
{
	$license = true;
}

/**
 * Можно вывести текстовый статус лицензии
 *
 * NOTE: например в панели скрипта или в лог, что бы знать в каком состоянии находится лицензия.
 */
echo $protect->errors;

/**
 * Так же можно вывести имя (логин), на которое выдана лицензия
 */
echo $protect->user_name;


