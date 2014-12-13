CREATE TABLE `pcp_license_keys` (
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор лицензии',
	`user_id` INT(11) NOT NULL COMMENT 'Уникальный иднетификаторклиента в системе',
	`user_name` VARCHAR(200) NOT NULL COMMENT 'Уникальное имя клиента в системе',
	`l_name` TEXT NOT NULL COMMENT 'Имя лицензии',
	`l_started` VARCHAR(11) NOT NULL COMMENT 'Дата и время добавления лицензии',
	`l_expires` VARCHAR(11) NOT NULL COMMENT 'Дата и время окончания лицензии',
	`l_key` VARCHAR(255) NOT NULL COMMENT 'Лицензионный ключ активации',
	`l_domain` VARCHAR(245) NOT NULL COMMENT 'Доменное имя, для которого предназначена лицензия',
	`l_domain_wildcard` TINYINT(1) NOT NULL,
	`l_ip` TEXT NOT NULL COMMENT 'Айпи адрес пользователя, с которого была выполнена активация',
	`l_directory` TEXT NOT NULL COMMENT 'Путь до скрипта где установлен он в системе у клиента',
	`l_server_hostname` TEXT NOT NULL COMMENT 'Имя хоста,где установлен скрипт',
	`l_server_ip` TEXT NOT NULL COMMENT 'Айпи адрес сервера,на которой установлена копия для данной лицензии',
	`l_status` TINYINT(1) NOT NULL COMMENT 'Статус лицензии, 0 - не активирована, 1 - активирована, 2 - срок истек, 3 - лицензия переиздана',
	`l_method_id` INT(11) NOT NULL COMMENT 'Идентификатор метода проверки лицензии',
	`l_last_check` INT(11) NOT NULL COMMENT 'Дата последней проверки',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=0;

CREATE TABLE `pcp_license_methods` (
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор метода',
	`name` TEXT NOT NULL COMMENT 'Название метода',
	`secret_key` TEXT NOT NULL COMMENT 'Секретный ключ',
	`check_period` INT(11) NOT NULL COMMENT 'Период проверки в днях',
	`enforce` TEXT NOT NULL COMMENT 'Что проверять',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=0;

CREATE TABLE `pcp_license_logs` (
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор лога',
	`date` INT(11) NOT NULL COMMENT 'Дата действия',
	`status` TINYINT(1) NOT NULL COMMENT 'Статус действия, 0 - не активирована, 1 - активирована, 2 - срок истек, 3 - лицензия переиздана',
	`l_status` VARCHAR(150) NOT NULL COMMENT 'Текстовый статус лицензии при проверке',
	`l_id` INT(11) NOT NULL COMMENT 'Id лицензии если существует',
	`l_key` VARCHAR(255) NOT NULL COMMENT 'Лицензионный ключ активации который был использован',
	`l_domain` VARCHAR(245) NOT NULL COMMENT 'Доменное имя которое было использовано',
	`l_ip` TEXT NOT NULL COMMENT 'Айпи адрес пользователя, с которого была выполнена операция',
	`l_directory` TEXT NOT NULL COMMENT 'Путь до скрипта где установлен скрипт в системе у клиента',
	`l_server_hostname` TEXT NOT NULL COMMENT 'Имя хоста, где установлен скрипт',
	`l_server_ip` TEXT NOT NULL COMMENT 'Айпи адрес сервера,на которой установлена копия для данной лицензии',
	`l_method_id` INT(11) NOT NULL COMMENT 'Идентификатор метода проверки лицензии',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=0;

CREATE TABLE `pcp_users` (
	`user_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор пользователя',
	`email` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Почта пользователя',
	`password` VARCHAR(32) NOT NULL DEFAULT '' COMMENT 'Пароль пользователя',
	`name` VARCHAR(40) NOT NULL DEFAULT '' COMMENT 'Логин пользователя',
	`user_group` SMALLINT(5) NOT NULL DEFAULT '4' COMMENT 'Группа пользователя',
	PRIMARY KEY (`user_id`),
	UNIQUE KEY `name` (`name`),
	UNIQUE KEY `email` (`email`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=0;


CREATE TABLE `pcp_events_logs` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL COMMENT 'Название события',
	`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`event_data` text NOT NULL COMMENT 'Данные о событии',
	PRIMARY KEY (`id`),
	KEY `name` (`name`)
) 
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=0;