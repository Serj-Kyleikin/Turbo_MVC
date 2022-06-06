<?php

namespace application\core;

class RouteController {

    public $controller = '\application\core\Controller';    // Базовый контроллер
    public $plugin;                                         // Контроллер плагина

    public function __construct() {

        // Определение маршрута

        $url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $path = ($url[0] == '') ? 'main' : $url[0];

        // Проверка используется ли плагин

        $ds = DIRECTORY_SEPARATOR;
        $plugins = require_once $_SERVER['DOCUMENT_ROOT'] . $ds . 'plugins' . $ds . 'settings.php';

        if($plugins['pages']['status'] === true) {                          // Плагины есть
            foreach($plugins['pages']['plugins'] as $name => $options) {

                if($options['status'] == true) {                            // Плагин включен
                    foreach($options['routes']['entities'] as $route) {

                        if($route == $url[$options['routes']['level']]) {   // Точка монтирования
                            $this->plugin = $name;
                            $this->controller = '\plugins\\' . $name . '\PluginController';
                        }
                    }
                }
            }
        }

        // Запуск конструктора базового контроллера (С методами контроллера плагина при необходимости)

        new $this->controller($path, $this->plugin);
    }
}