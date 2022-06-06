<?php

namespace plugins\users;

use application\core\Controller;
use application\core\View;
use application\core\Model;

class PluginController extends Controller {

    public function start($route) {

        // Маршрутизация

        if($route == 'authorization' and isset($_COOKIE['name'])) {
            if($this->model->checkUser() == 'checked') $this->view->redirect('cabinet');
        }
    }
}