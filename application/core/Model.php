<?php

namespace application\core;

use librarys\Cache;
use librarys\Log;
use PDO;

class Model {

	protected $connection;      // Дескриптор подключения
    protected $cache;           // Объект кэширования
    protected $log;             // Объект логирования

	public function __construct() {

        $connection = require $_SERVER['DOCUMENT_ROOT'] . '/configurations/connection.php';

        define('DEBUG_MODE', TRUE);
        if(DEBUG_MODE) $pdoAttributes[PDO::ATTR_ERRMODE] = PDO::ERRMODE_WARNING;

        try { 
			$this->connection = new PDO('mysql:host='.$connection['host'].';dbname='.$connection['db_name'].'', $connection['user'], $connection['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch(PDOException $e) { 
			echo "Нет соединения с базой данных";
		}

        $this->getLibrarys();   // Загрузка библиотек

        // Запуск асинхронных методов из JS

        if(isset($_POST['ajaxMethod']) and $_POST['ajaxMethod'] != '') {
			$method = $_POST['ajaxMethod'];
			$this->$method();
		}
	}

    // Подключение библиотек

    public function getLibrarys() {

        require_once $_SERVER['DOCUMENT_ROOT'] . '/librarys/Log.php';       // Логирование
        $this->log = new Log;

        require_once $_SERVER['DOCUMENT_ROOT'] . '/librarys/Cache.php';     // Кэширование
        $this->cache = new Cache;
    }

    // Получение данных страницы (Общий метод всех моделей)

    public function getInfo($route, $plugin, $advance = []) {

        $component = ($plugin != NULL) ? 'plugins': 'pages';

        // Формирование условия

            // $route == первый (базовый) элемент в URL адресе
            // $advance == запрашиваемый элемент в URL адресе

        if($advance != []) {
            $condition = 'WHERE name =:name and advance =:advance';
            $data['advance'] = $advance;
        } else {
            $condition = 'WHERE name =:name';
        }

        $sql = "SELECT * FROM settings_$component $condition";

        $data['name'] = $route;
        $getInfo = $this->connection->prepare($sql);
        $getInfo->execute($data);

        return $getInfo->fetch(PDO::FETCH_ASSOC);
    }
}