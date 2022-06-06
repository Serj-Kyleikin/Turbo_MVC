<?php

namespace librarys\configuration;

use PDO;

if(count($_POST) == 4) {

    $ds = DIRECTORY_SEPARATOR;
    
    // Создание файлов и папок

    $cache_dir = $_SERVER['DOCUMENT_ROOT'] . "/cache";
    mkdir($cache_dir, 0777, True);

    $logs_dir = $_SERVER['DOCUMENT_ROOT'] . "/logs";
    mkdir($logs_dir, 0777, True);

    // Создание дескриптора подключения

    $file = $_SERVER['DOCUMENT_ROOT'] . $ds . 'configurations' . $ds . 'connection.php';

    $data = "<?php 
    return ['host' => '{$_POST['host']}',
        'db_name' => '{$_POST['base']}',
        'password' => '{$_POST['password']}',
        'user' => '{$_POST['login']}'
    ];";

    file_put_contents($file, $data);

    // Подготовка данных

    $start = new PDO("mysql:host={$_POST['host']}", "{$_POST['login']}", "{$_POST['password']}");
    $query = "CREATE DATABASE IF NOT EXISTS {$_POST['base']} CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    $start->exec($query);

    $descriptor = new PDO('mysql:host='.$_POST['host'].';dbname='.$_POST['base'].'', $_POST['login'], $_POST['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $descriptor->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Создание таблиц

    $tables = require_once $_SERVER['DOCUMENT_ROOT'] . '/librarys/configuration/tables.php';

    foreach($tables as $table => $info) {

        $query = "CREATE TABLE IF NOT EXISTS {$table} (";
        foreach($info as $row) $query .= $row;
        $query .= ")";

        $create= $descriptor->prepare($query);
        $create->execute();
    }

    // Загрузка контента

    foreach(glob($_SERVER['DOCUMENT_ROOT'] . '/librarys/configuration/content/*') as $file) {

        $content = require_once $file;
        $table = explode('.php', explode('/content/', $file)[1])[0];

        if(preg_match('#__#', $table)) $table = explode('__', $table)[0];

        foreach($content as $info) {

            if($table == 'plugin_formBuilder_forms') {

                $file_json = $_SERVER['DOCUMENT_ROOT'] . $ds . 'librarys' . $ds . 'configuration' .  $ds . 'objects' .  $ds . 'form.json';
                $code = file_get_contents($file_json);

                $query = "INSERT INTO plugin_formBuilder_forms (name, code) VALUES('jobs', {$code})";

                $sentCode = $descriptor->prepare($query);
                $sentCode->execute();

            } else {

                $query = "INSERT INTO {$table} (";
                $rows = $values = '';
                $data = [];

                foreach($info as $row => $value) {

                    $rows .= "{$row}, ";

                    if($row != 'date') {
                        $values .= ":{$row}, ";
                        $data[$row] = $value;
                    } else {
                        $values .= $value;
                    }
                }

                $rows = trim($rows, ', ');
                $values = trim($values, ', ');

                $query .= "{$rows}) VALUES({$values})"; 

                $insert = $descriptor->prepare($query);
                $insert->execute($data);
            }
        }
    }

} else {
    header('location: /installation.php');
}
