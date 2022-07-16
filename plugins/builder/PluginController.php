<?php

namespace plugins\builder;

use application\core\Controller;
use application\core\Model;

class PluginController extends Controller {

    public function start($info) {

        // Маршрутизация

        if(!isset($_COOKIE['user'])) redirect('authorization');
        
        // Получение данных модели

        return $this->model->getData($info);
    }
}