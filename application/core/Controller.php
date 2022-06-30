<?php

namespace application\core;

use application\core\View;
use application\core\Model;
use libraries\Log;

class Controller {

    protected $model;           // Объект модели
    protected $view;            // Объект вида
    protected $log;             // Объект логов

    public function __construct($route, $plugin) {

        $this->getlibraries();   // Загрузка библиотек

        $this->view = new View;

        // Создание модели

        if($plugin != NULL) {   // Если это плагин

            $file = 'plugins/' . $plugin . '/models/PluginModel.php';

            if(file_exists($file)) {        // Отслеживание ошибок

                $path = '\plugins\\' .  $plugin . '\models\PluginModel';

                if(class_exists($path)) {    // Отслеживание ошибок

                    // Запуск конструктора базовой модели с методами модели плагина

                    $this->model = new $path;
                    $this->start($route);       // Запуск контроллера плагина

                } else {

                    $this->log->write(6, 'Отсутствует класс плагина: ' . $plugin . '.');
                    $this->view->show404($info);
                }

            } else {

                $this->log->write(6, 'Отсутствует файл плагина: ' . $file . '.');
                $this->view->show404($info);
            }

        } else {    // Без плагина

            $file = 'application/models/' . ucfirst($route) . 'Model.php';

            // Нулевому элементу URL соответствует один файл модели

                // Последующие элементы URL, отслеживаются в подключённой модели и связаны с дочерними моделями

            if(file_exists($file)) {
                $path = '\application\models\\' . ucfirst($route) . 'Model';
                $this->model = new $path;
            } else {                        // Отсутствие модели == отсутствиие страницы на сайте
                $this->view->show404($info);
            }
        }

        // Получение данных модели и запуск рендеринга

        $method = 'get' . ucfirst($route);

        if(method_exists($this->model, $method)) {

            // Одна страница сайта == один базовый метод в модели

            $info = $this->model->$method($route, $plugin);
            $this->view->rendering($route, $plugin, $info);     // Запуск сборки страницы

        } else {        // Отсутствие метода в модели == отсутствиие страницы на сайте
            $this->view->show404($info);
        }
    }

    // Подключение библиотек (Библиотека, в отличие от плагина - часть ядра)

    public function getlibraries() {

        require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/Log.php';       // Логирование
        $this->log = new Log;
    }
}