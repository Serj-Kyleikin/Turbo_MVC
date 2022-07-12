<?php

namespace application\core;

class RouteController {

    public $controller = '\application\core\Controller';    // Базовый контроллер
    public $settings;                                       // Настройки плагинов
    public $info = [];                                      // Параметры
    public $errors = [                                      // Коды ошибок
        '0' => 'отсутствует файл настроек плагинов: ',
        '1' => 'Некорректно заполнены настройки плагина: ',
        '2' => 'отсутствует файл контроллера плагина: ',
        '3' => 'отсутствует класс контроллера плагина: '
    ];

    public function __construct() {

        // Определение маршрута

        $url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->info['path'] = ($url[0] == '') ? 'main' : $url[0];

        if(P_MODE and $this->getSettings()) $this->checkPlugin($url);       // Поиск плагинов

        new $this->controller($this->info);                                 // Запуск конструктора базового контроллера

        $this->settings = $this->controller = $this->info = $this->errors = null;
    }

    // Получение настроек плагинов

    public function getSettings() {

        $ds = DIRECTORY_SEPARATOR;
        $file = $_SERVER['DOCUMENT_ROOT'] . $ds . 'plugins' . $ds . 'settings.php';

        if(D_MODE) {
            try {
                if(!file_exists($file)) throw new \Exception($this->errors[0] . $file);
            } catch(\Exception $e) {
                logError($e, 0);
            }
        }

        $this->settings = require_once $file;
        return true;
    }

    // Поиск плагина

    public function checkPlugin($url) {

        foreach($this->settings['pages'] as $name => $options) {

            // Плагин включен и корректно настроен

            if($options['status']) {

                if(D_MODE) {
                    try {
                        if(!isset($options['routes']['entities']) or !isset($options['routes']['level']) or !isset($options['options'])) throw new \Exception($this->errors[1] . $name);
                    } catch(\Exception $e) {
                        logError($e, 0);
                    }
                }

                foreach($options['routes']['entities'] as $route) {

                    if($route == $url[$options['routes']['level']]) {

                        $file = 'plugins/' . $name . '/PluginController.php';
                        $class = '\plugins\\' .  $name . '\PluginController';

                        if(D_MODE) {
                            try {
                                if(!file_exists($file)) throw new \Exception($this->errors[2] . $file);
                                if(!class_exists($class)) throw new \Exception($this->errors[3] . $class);
                            } catch(\Exception $e) {
                                logError($e, 0);
                            }
                        }

                        $this->info['plugin'] = $name;
                        $this->info['plugin_settings'] = $options['options'];
                        $this->controller = $class;
                    }
                }
            }
        }
    }
}