<?php

namespace plugins\cabinet;

use application\core\Controller;
use application\core\Model;

class PluginController extends Controller {

    public function start($info, $method) {

        // Маршрутизация

        if(isset($_COOKIE['admin'])) {

            if($this->model->checkUser() == 'checked') {
                if($info['path'] == 'authorization') redirect('cabinet');
            } else {
                if($info['path'] == 'cabinet') redirect('authorization');
            }

        } else {
            if($info['path'] == 'cabinet') redirect('authorization');
        }

        // Получение данных модели

        return $this->model->$method($info);
    }
}