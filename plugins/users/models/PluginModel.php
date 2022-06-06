<?php

namespace plugins\users\models;

use application\core\Model;
use PDO;

class PluginModel extends Model {

    // Проверка пользователя

    public function checkUser() {

        $prepare['personal_id'] = explode('_', $_COOKIE['name'])[0];
        $prepare['secret'] = explode('_', $_COOKIE['name'])[1];

        $check= $this->connection->prepare("SELECT secret FROM plugin_users WHERE personal_id=:personal_id and secret=:secret");
        $check->execute($prepare);

        $row = $check->fetch(PDO::FETCH_ASSOC);

        if(isset($row['secret'])) return 'checked';
        else setcookie('name', '$value', time()-86400, '/');
    }

    // Страница Авторизация

    public function getAuthorization($route, $plugin) {

        $info = $this->cache->read('cache_module_authorization.tmp');

        if(empty($info)) {

            $info['settings'] = $this->getInfo($route, $plugin);

            $this->cache->write('cache_module_authorization.tmp', $info);
        }

        return $info;
    }
}