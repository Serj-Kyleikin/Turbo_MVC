<?php

namespace application\core;

use libraries\Cache;
use libraries\Log;
use PDO;

class Model {

	protected $connection;      // Дескриптор подключения
    public $cache;              // Объект кэширования
    public $log;                // Объект 

    public $errors = [
        '0' => 'Отсутствует файл подключения к БД: '
    ];

	public function __construct($method = []) {

        $connection = $this->getConfiguration();                   // Получение данных подключения к БД

        $options = [
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
           PDO::ATTR_EMULATE_PREPARES => false,
           PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ];
       
        try { 
			$this->connection = new PDO('mysql:host='.$connection['host'].';dbname='.$connection['db_name'].'', $connection['user'], $connection['password'], $options);
		} catch (\PDOException $e) {
            logError($e, 1);
        }

        // Запуск асинхронных методов из JS

        if($method != []) {

            $this->loadLibraries();                     // Подключение библиотек
			$this->$method();

		} else $this->getLibraries();                   // Загрузка библиотек
	}

    // Получение данных подключения к БД

    public function getConfiguration() {

        $file = $_SERVER['DOCUMENT_ROOT'] . '/configurations/connection.php';

        if(D_MODE) {
            try {
                if(!file_exists($file)) throw new \Exception($this->$errors[0] . $file);
            } catch(\Exception $e) {
                logError($e, 0);
            }
        }

        $connection = require $file;
        return $connection;
    }

    // Подключение библиотек

    public function getLibraries() {
        $this->cache = new Cache;                       // Кэширование
    }

    // Загрузка библиотек для AJAX модели

    public function loadLibraries() {

        require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/Log.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/Cache.php';

        $this->log = new Log;                           // Логирование

        $this->getLibraries();
    }

    // Получение данных модели (Фасад)

    public function getData($info) {

        $type = (isset($info['plugin'])) ? 'plugin_' : 'page_';
        $cache = $type . $info['path'] . '.tmp';

        $data = $this->cache->read($cache);

        if(empty($data)) {

            $method = $info['method'];

            $data['content'] = $this->$method($info);
            $data['settings'] = $this->getInfo($info);

            $this->cache->write($cache, $data);
        }

        return $data;
    }

    // Получение данных страницы (Общий метод всех моделей)

    public function getInfo($info, $advance = []) {

        $component = (isset($info['plugin'])) ? 'plugins': 'pages';

        // Формирование условия

            // $info['path'] == первый (базовый) элемент в URL адресе
            // $advance == запрашиваемый элемент в URL адресе

        if($advance != []) {
            $condition = 'WHERE name =:name and advance =:advance';
            $data['advance'] = $advance;
        } else {
            $condition = 'WHERE name =:name';
        }

        $data['name'] = $info['path'];
        $sql = "SELECT * FROM settings_$component $condition";

        try {

            $getInfo = $this->connection->prepare($sql);
            $getInfo->execute($data);

            return $getInfo->fetch(PDO::FETCH_ASSOC);

        } catch(\PDOException $e) {
            logError($e, 1);
        }
    }

    // Проверка пользователя

    public function checkUser() {

        $secret = substr(explode('_', $_COOKIE['user'])[0], 0, -2);
        $key = (int)$secret / 3;
        $prepare['user_id'] =  substr($key, 2, -2);
        $prepare['secret'] = explode('_', $_COOKIE['user'])[1];

        try {

            $check = $this->connection->prepare("SELECT secret FROM plugin_users_secure WHERE user_id=:user_id and secret=:secret");
            $check->execute($prepare);

            $row = $check->fetch(PDO::FETCH_ASSOC);

        } catch(\PDOException $e) {
            logError($e, 1);
        }

        if(isset($row['secret'])) return 'checked';
        else setcookie('user', '', time()-86400, '/');
    }
}