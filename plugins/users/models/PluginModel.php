<?php

namespace plugins\users\models;

use application\core\Model;
use PDO;

class PluginModel extends Model {

    // Страница Авторизация

    public function getAuthorization($info) {

        $data = $this->cache->read('plugin_authorization.tmp');

        if(empty($data)) {

            $data['settings'] = $this->getInfo($info);

            $this->cache->write('plugin_authorization.tmp', $data);
        }

        return $data;
    }
}