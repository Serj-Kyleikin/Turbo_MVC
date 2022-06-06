<?php

namespace plugins\cabinet;

use application\core\Controller;
use application\core\View;
use application\core\Model;

class PluginController extends Controller {

    public function start($route) {

        // Маршрутизация

        if(isset($_COOKIE['name'])) {

            if($this->model->checkUser() == 'checked') {
                if($route == 'authorization') $this->view->redirect('cabinet');
            } else {
                if($route == 'cabinet') $this->view->redirect('authorization');
            }

        } else {
            if($route == 'cabinet') $this->view->redirect('authorization');
        }
    }
}