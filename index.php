<?php

session_start();

// Настройки администратора

ini_set('display_errors', 0);   // 0 - публичное размещение. 1 - отладка.
error_reporting(E_ALL);

function p($data) {
    echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

function e($data) {
    echo '<pre>';
	var_dump($data);
	echo '</pre>';
    exit;
}

// Автозагрузка классов

spl_autoload_register(function($class) {

	$ds = DIRECTORY_SEPARATOR;
    $path = $_SERVER['DOCUMENT_ROOT'] . $ds . str_replace('\\', $ds, $class) . '.php';

    if(file_exists($path)) require $path;
});

// Запуск маршрутизатора

$routeController = '\application\core\RouteController';
new $routeController;