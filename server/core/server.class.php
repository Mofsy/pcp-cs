<?php
/**
 * PHP code protect
 *
 * @link          https://github.com/Mofsy/pcp-cs
 * @author        Oleg Budrin <ru.mofsy@yandex.ru>
 * @copyright     Copyright (c) 2013-2015, Oleg Budrin (Mofsy)
 */

namespace Mofsy\License\Server\Core;

class Protect
{

    /**
     * Префикс таблиц базы данных
     *
     * @var string
     */
    private $db_prefix = 'pcp';

    /*
     * Название таблицы с ключами активации
     */
    private $db_table_keys = 'license_keys';

    /*
     * Название таблицы с методами проверки ключей активации
     */
    private $db_table_methods = 'license_methods';

    /*
     * Название таблицы с логом обращений к ключам активации
     */
    private $db_table_logs = 'license_logs';

    /*
     * Название таблицы с логом событий
     */
    private $db_table_events_logs = 'events_logs';

    /*
     * Название таблицы с данными о пользователях
     */
    private $db_table_users = 'users';

    /**
     * Объект базы данных
     *
     * @var object
     */
    private $db;

    /**
     * Конструктор класса
     *
     * @param array $config
     */
    public function __construct($config)
    {
        /*
         * Префикс таблиц
         */
        if(isset($config['db_prefix']))
        {
            $this->db_prefix = $config['db_prefix'];
        }

        /*
         * Название таблиц
         */
        if(isset($config['db_table_users']))
        {
            $this->db_table_users = $config['db_table_users'];
        }
        if(isset($config['db_table_logs']))
        {
            $this->db_table_logs = $config['db_table_logs'];
        }
        if(isset($config['db_table_keys']))
        {
            $this->db_table_keys = $config['db_table_keys'];
        }
        if(isset($config['db_table_methods']))
        {
            $this->db_table_methods = $config['db_table_methods'];
        }
        if(isset($config['db_table_events_logs']))
        {
            $this->db_table_events_logs = $config['db_table_events_logs'];
        }

        /*
         * Создаем объект подключения к базе данных
         */
        $this->db = new Mysqli($config['db_user'],$config['db_pass'], $config['db_name'], $config['db_host']);
    }

    /**
     * Деструктор класса
     */
    public function __destruct()
    {
    }

    /**
     * Запускаем сервер на прослушивание запроов от клиента
     */
    public function run()
    {
        // TODO: Сделать занесение всех обращений в таблицу логов базы данных

        if ($client_data = $this->clientDataGet())
        {
            /*
             * Запрашиваем все данные о лицензионном ключе из базы данных по ключу клиента
             */
            if ($key_data = $this->licenseKeyGet($client_data['key'])) {

                /*
                 * Если лицензионный ключ не активирован или переиздан, обновляем данные клиента (домен, ip, hostname, mac)
                 */
                if ($key_data['status'] === 0 || $key_data['status'] === 3)
                {
                    $key_data = $this->licenseKeyActivate($client_data);
                }

                /*
                 * Запрашиваем все необходимое о методе из базы данных по полученному ID
                 */
                $method_data = $this->licenseKeyMethodGet($key_data['method_id']);

                /*
                 * Создаем локальный ключ
                 */
                $local_key = $this->localKeyCreate($key_data, $method_data);

                /*
                 * Обновляем последнее обращение к ключу
                 */
                $this->licenseKeyCheckLastUpdate($client_data['key']);
                
                /*
                 * Добавляем запись о событии в лог
                 */
                $this->addToLog('key_check', $client_data);
                
                /*
                 * Скармливаем клиенту локальный ключ
                 */
                die($local_key);
            }

            die('Invalid');
        }
        else
        {
            die('Invalid');
        }
    }

    /**
     * Генерация локального ключа
     *
     * @param array $key_data Информация о лицензии
     * @param array $method_data Информация о методе проверки лицензионного ключа
     *
     * @return string
     */
    public function localKeyCreate($key_data, $method_data)
    {
        /**
         * Массив с указателями проверки
         * Можно проверять домен, айпи адрес, имя хоста
         */
        $instance = array();
        // todo: добавить остальные данные (ip, hostname).

        $instance['domain'][] =  $key_data['domain'];
        $instance['domain'][] =  'www.' . $key_data['domain'];
        if(isset($key_data['domain_wildcard'])){
            if($key_data['domain_wildcard'] == 1){
                $instance['domain'][] = '*.' . $key_data['domain'];
            }
            elseif($key_data['domain_wildcard'] == 2){
                $instance['domain'][] = '*.' . $key_data['domain'] . '.*';
            }
            elseif($key_data['domain_wildcard'] == 3){
                $instance['domain'][] = $key_data['domain'] . '.*';
            }
        }

        /**
         * Данные о том, что следует проверять
         */
        $local_key['instance'] = $instance;

        /**
         * Маркер проверки, указывает на то, что надо проверять в данных
         */
        $local_key['enforce'] = $method_data['enforce'];

        /**
         * Маркер проверки доменного имени
         */
        $local_key['domain_wildcard'] = $key_data['domain_wildcard'];

        /**
         * Уникальный идентификатор клиента
         */
        $local_key['user_id'] = (integer)$key_data['user_id'];

        /**
         * Уникальный логин клиента на сайте
         */
        $local_key['user_name'] = (string)$key_data['user_name'];

        /**
         * Ключ активации
         */
        $local_key['activation_key'] = (string)$key_data['key'];

        /**
         * Дата начала действия лицензии в Unix-времени
         */
        $local_key['license_started'] = (integer)$key_data['started'];

        /**
         * Дата окончания лицензии в Unix-времени
         *
         * NOTE: возможно указать значение never, в данном случае оно равняется бесконечности.
         */
        $local_key['activation_key_expires'] = $key_data['expires'];

        /**
         * Время истечения локального ключа
         *
         * Формула:
         * берем количество дней из метода, умножаем его на количество секунд в сутках и прибавляем к Unix-времени.
         */
        $local_key['local_key_expires'] = ((integer)$method_data['check_period'] * 86400) + time();

        /**
         * Статус лицензии
         *
         * 0 - активна (не использована)
         * 1 - активна (использована)
         * 2 - срок истек
         * 3 - лицензия переиздана (использование обнулено)
         * 4 - действие приостановлено
         */
        $local_key['status'] = (integer)$key_data['status'];

        /**
         * Кастомные поля
         */
        $local_key['custom_fields'] = array();

        /**
         * Время истечения срока скачивания модуля
         */
        $local_key['download_access_expires'] = 0;

        /**
         * Время истечения срока поддержки
         */
        $local_key['support_access_expires'] = 0;

        /**
         * Сериализуем все данные локального ключа
         */
        $local_key = serialize($local_key);

        /**
         * Конечная обработка всех данных
         */
        $license_info = array();
        $license_info[0] = $local_key;
        $license_info[1] = md5($method_data['secret_key'] . $license_info[0]);
        $license_info[2] = md5(microtime());
        $license_info = base64_encode(implode("{protect}", $license_info));

        return urlencode(wordwrap($license_info, 64, "\n", 1));
    }

    /**
     * Создание лицензионного ключа
     *
     * @return string 25 значный ключ активации (5 пар по 5)
     */
    public function licenseKeyGen()
    {
        $key = md5(time());
        $new_key = '';
        for ($i = 1; $i <= 25; $i++)
        {
            $new_key .= $key[$i];
            if ($i % 5 === 0 && $i !== 25)
            {
	            $new_key .= '-';
            }
        }

        return strtoupper($new_key);
    }

    /**
     * Добавление нового ключа активации в базу данных
     *
     * @param integer|string $expires Срок окончания лицензии в Unix формате; Либо never при вечной лицензии.
     * @param integer $method Идентификатор метода проверки лицензионного ключа
     * @param integer $status Статус лицензионного ключа
     * @param integer $domain_wildcard Разрешено ли использовать на поддоменах (
     *                                 0 - запрещено, 
     *                                 1 - разрешено на разных подоменах основного домена, 
     *                                 2 - разрешено на разных поддоменах включая разные доменные зоны основного домена, 
     *                                 3 - разрешено на разных доменных зонах основного домена
     *                                 ) 
     * @param string $l_name Название лицензии
     * @param integer $user_id ID пользователя
     * @param string $user_name Логин пользователя
     * 
     *
     * @return array Информация о вновь созданном ключе
     */
    public function licenseKeyCreate($expires, $method, $status = 0, $domain_wildcard = 0, $l_name = '', $user_id = 0, $user_name = '')
    {
        $new_key_data = array();

        // генерируем ключ
        $new_key_data['key'] = $this->licenseKeyGen();

        // получаем дату создания ключа
        $new_key_data['started'] = time();
        
        // дата окончания срока действия
        $new_key_data['expires'] = $expires;

        // идентификатор метода проверки ключа
        $new_key_data['method'] = $method;

        // Разрешено ли использовать на поддоменах
        $new_key_data['domain_wildcard'] = $domain_wildcard;
        
         // Название лицензии
        $new_key_data['l_name'] = $l_name;

        $this->db->query(
            "INSERT INTO " . $this->db_prefix . "_" . $this->db_table_keys . "
            SET 
            `user_id` = '$user_id', 
            `user_name` = '{$user_name}', 
            `l_status` = '$status', 
            `l_name` = '{$l_name}', 
            `l_started` = '{$new_key_data['started']}', 
            `l_expires` = '$expires', 
            `l_key` = '{$new_key_data['key']}', 
            `l_domain_wildcard` = '$domain_wildcard', 
            `l_method_id`  = '$method'"
            );

        $new_key_data['id'] = $this->db->insert_id();

        return $new_key_data;
    }

    /**
     * Добавление нового метода проверки ключа активации
     *
     * @return array|boolean Информация о вновь созданном методе при успехе; false при ошибке;
     */
    public function licenseKeyMethodCreate($name, $secret_key, $check_period, $enforce)
    {
        $new_method_data = array();

        // Название
        $new_method_data['name'] = (string)$name;

        // Секретный ключ метода
        $new_method_data['secret_key'] = (string)$secret_key;

        $result = $this->db->query("SELECT * FROM " . $this->db_prefix . "_" . $this->db_table_methods . " WHERE secret_key = '{$new_method_data['secret_key']}'");
        $row = $this->db->get_row($result);
        if (count($row) > 0) {
            return false;
        }

        // Период проверки локального ключа в днях
        $new_method_data['check_period'] = (integer)$check_period;

        // Маркер метода проверки локального ключа, если несколько значений, то через запятую.
        $new_method_data['enforce'] = $enforce;

        $this->db->query("INSERT INTO " . $this->db_prefix . "_" . $this->db_table_methods . " SET name = '{$new_method_data['name']}', secret_key = '{$new_method_data['secret_key']}', check_period = '{$new_method_data['check_period']}', enforce = '{$new_method_data['enforce']}'");

        // Идентификатор метода проверки ключа активации
        $new_method_data['id'] = $this->db->insert_id();

        $this->db->free($result);

        return $new_method_data;
    }

    /**
     * Получение информации о методе проверки лицензионного ключа по id
     *
     * @param integer $license_key_method_id Идентификатор метода проверки лицензионного ключа
     *
     * @return array|boolean Массив с информацией о методе, либо false при отсутствие метода
     */
    public function licenseKeyMethodGet($license_key_method_id)
    {
        $method_data = array();

        $result = $this->db->query("SELECT * FROM " . $this->db_prefix . "_" . $this->db_table_methods . " WHERE id='{$license_key_method_id}'");
        $row = $this->db->get_row($result);

        /**
         * Секретный ключ метода
         */
        $method_data['secret_key'] = $row['secret_key'];

        /**
         * Маркер того, что проверять
         */
        $method_data['enforce'] = explode(",", $row['enforce']);

        /**
         * Период проверки локального ключа в днях
         */
        $method_data['check_period'] = $row['check_period'];

        $this->db->free($result);

        return $method_data;
    }

    /**
     * Получение всей информации о лицензионном ключе по ключу
     *
     * @param string $key Лицензионный ключ активации
     *
     * @return array|boolean Массив с информацией о ключе, либо false при отсутствие ключа
     */
    public function licenseKeyGet($key)
    {

        $result = $this->db->query("SELECT * FROM " . $this->db_prefix . "_" . $this->db_table_keys . " WHERE l_key='$key' LIMIT 0,1");
        $row = $this->db->get_row($result);

        if (count($row) > 0) {
            $key_data = array();

            /**
             * Идентификатор лицензионного ключа
             *
             * @var integer
             */
            $key_data['id'] = $row['id'];

            /**
             * Лицензионный ключ активации
             *
             * @var string
             */
            $key_data['key'] = $row['l_key'];

            /**
             * Идентификатор клиента (например на сайте)
             *
             * @var integer
             */
            $key_data['user_id'] = $row['user_id'];

            /**
             * Логин клиента (например на сайте)
             *
             * @var string
             */
            $key_data['user_name'] = $row['user_name'];

            /**
             * Доменное имя на которое был активирован лицензионный ключ
             *
             * @var string
             */
            $key_data['domain'] = $row['l_domain'];

            /**
             * Разрешено ли использовать на поддоменах
             *
             * 0 - запрещено
             * 1 - разрешено на разных подоменах основного домена
             * 2 - разрешено на разных поддоменах включая разные доменные зоны основного домена
             * 3 - разрешено на разных доменных зонах основного домена
             */
            $key_data['domain_wildcard'] = $row['l_domain_wildcard'];

            /**
             * Айпи адрес сервера на который был активирован лицензионный ключ
             */
            $key_data['ip'] = $row['l_ip'];

            /**
             * Директория где находится клиент
             */
            $key_data['directory'] = $row['l_directory'];

            /**
             * Название хоста на котором был активирован лицензионный ключ
             */
            $key_data['server_hostname'] = $row['l_server_hostname'];

            /**
             * Айпи адрес хоста где находится клиент
             */
            $key_data['server_ip'] = $row['l_server_ip'];

            /**
             * Статус лицензии
             *
             * 0 - не активирована
             * 1 - лицензия активирована
             * 2 - срок истек
             * 3 - лицензия переиздана (сделано обнуление)
             * 4 - приостановлена (лицензия была принудительно остановлена)
             */
            $key_data['status'] = $row['l_status'];

            /**
             * Метод проверки лицензионного ключа
             */
            $key_data['method_id'] = $row['l_method_id'];

            /**
             * Дата начала срока действия лицензионного ключа в UNIX формате
             */
            $key_data['started'] = $row['l_started'];

            /**
             * Дата окончания срока действия лицензионного ключа в UNIX формате
             */
            $key_data['expires'] = $row['l_expires'];

            return $key_data;
        }

        $this->db->free($result);

        return false;
    }

	/**
	 * Активация лицензионного ключа
	 *
	 * @param array $client_data Данные полученние от клиента
	 *
	 * @return array|boolean
	 */
    public function licenseKeyActivate($client_data)
    {
        $this->db->query("UPDATE " . $this->db_prefix . "_" . $this->db_table_keys . " SET l_domain='{$client_data['domain']}', l_ip='{$client_data['ip']}', l_directory='{$client_data['directory']}', l_server_hostname='{$client_data['server_hostname']}', l_server_ip = '{$client_data['server_ip']}', l_status='1' WHERE l_key='{$client_data['key']}'");

        return $this->licenseKeyGet($client_data['key']);
    }

    /**
     * Сброс активационных данных у ключа активации по ключу активации
     *
     * @param string $license_key Сбрасываемый ключ активации
     *
     * @return boolean
     */
    public function licenseKeyTruncateByKey($license_key)
    {
        if($this->db->query("UPDATE " . $this->db_prefix . "_" . $this->db_table_keys . " SET l_domain='', l_ip='', l_directory='', l_server_hostname='', l_server_ip = '', l_status='3' WHERE l_key='{$license_key}'"))
        {
	        return true;
        }

	    return false;
    }

    /**
     * Обновление статуса лицензионного ключа
     *
     * 0 - не активирован
     * 1 - лицензия активирована
     * 2 - срок истек
     * 3 - лицензия переиздана (сделано обнуление)
     * 4 - приостановлена (лицензия была принудительно остановлена)
     *
     * @param string $license_key Ключ активации
     * @param integer $status Новый статус ключа
     *
     * @return bool
     */
    public function licenseKeyStatusUpdateByKey($license_key, $status)
    {
        if ($status === 3)
        {
            $this->licenseKeyTruncateByKey($license_key);
        }
	    else
	    {
		    $this->db->query("UPDATE " . $this->db_prefix . "_" . $this->db_table_keys . " SET l_status='$status' WHERE l_key='$license_key'");
	    }

        return true;
    }

    /**
     * Получение данных пришедших от клиента
     *
     * @return array|boolean Данные в виде массива в случае успеха, false в случае ошибки
     */
    public function clientDataGet()
    {
        /**
         * Проверяем наличие пост запроса от клиента
         */
        if(isset($_POST['activation_key']))
        {
            $client_data = array();

            /**
             * Лицензионный ключ активации
             */
            $client_data['key'] = $this->db->filter(htmlspecialchars(trim(strip_tags((string)$_POST['activation_key']))));

            /**
             * Домен на котором установлен клиент (без www)
             */
            $client_data['domain'] = $this->db->filter(htmlspecialchars(trim(strip_tags((string)$_POST['domain']))));
            $client_data['domain'] = str_replace("www.", "", $client_data['domain']);

            /**
             * Айпи адрес клиента
             */
            $client_data['ip'] = $_POST['ip'];

            /**
             * Директория от root где установлен клиент
             */
            $client_data['directory'] = $this->db->filter(htmlspecialchars(trim(strip_tags((string)$_POST['directory']))));

            /**
             * Имя хоста где установлен лиент
             */
            $client_data['server_hostname'] = $this->db->filter(htmlspecialchars(trim(strip_tags((string)$_POST['server_hostname']))));

            /**
             * Айпи адрес сервера где установлен клиент
             */
            $client_data['server_ip'] = $this->db->filter(htmlspecialchars(trim(strip_tags($_POST['server_ip']))));

            return $client_data;
        }

        return false;
    }

    /**
     * Обновление времени обращения к лицензии
     *
     * @param string $license_key
     *
     */
    public function licenseKeyCheckLastUpdate($license_key)
    {
        $date = time();
        $this->db->query("UPDATE " . $this->db_prefix . "_" . $this->db_table_keys . " SET l_last_check='$date' WHERE l_key='$license_key'");
    }

    /*
     * Получение всех ключей активации
     */
    public function getActivationKeys()
    {
        $result = $this->db->query( "SELECT * FROM " . $this->db_prefix . "_" . $this->db_table_keys . " ORDER BY id" );

        $result_array = array();


        while ($row = $this->db->get_array($result) )
        {
            if(is_numeric($row['l_expires'])){
                $row['l_expires'] = date( 'd/m/Y - H:i', $row['l_expires'] );
            }
            $result_array[] = array(
                'id' => $row['id'],
                'domain' => $row['l_domain'],
                'started' => date( 'd/m/Y - H:i', $row['l_started'] ),
                'expires' => $row['l_expires'],
                'status' => $row['l_status'],
                'key' => $row['l_key']
            );
        }

        
        $this->db->free($result);
        return $result_array;
    }

    /*
     * Получение всех методов для ключей активации
     */
    public function getMethodAll()
    {
        $result = $this->db->query( "SELECT * FROM " . $this->db_prefix . "_" . $this->db_table_methods . " ORDER BY id DESC" );

        $result_array = array();

        while ($row = $this->db->get_array($result) )
        {
            $result_array[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'secret_key' => $row['secret_key'],
                'check_period' => $row['check_period'],
                'enforce' => $row['enforce']
            );
        }

        $this->db->free($result);

        return $result_array;
    }
    
    /**
     * Добавление события в лог
     *
     * @param string $event_name Имя события
     * @param array  $event_data Массив с даными о событии 
     */
    public function addToLog($event_name, $event_data = array()) 
    {
        $data = json_encode($event_data);

        $this->db->query("INSERT INTO " . $this->db_prefix . "_" . $this->db_table_events_logs . " SET `name` = '{$event_name}', `event_data` = '{$data}'");
    }
}
