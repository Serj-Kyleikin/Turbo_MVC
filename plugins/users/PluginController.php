<?php

namespace plugins\users;

use application\core\Controller;
use application\core\Model;

class PluginController extends Controller {

    public function start($info, $method) {

        // Маршрутизация

        if($info['path'] == 'authorization' and isset($_COOKIE['admin'])) {
            if($this->model->checkUser() == 'checked') redirect('cabinet');
        }

        // Получение данных модели

        return $this->model->$method($info);
    }
}