<?php

namespace plugins\builder\models;

use application\core\Model;
use PDO;

class PluginModel extends Model {

    // Кабинет

    public function getBuilder($info) {

        $data = $this->cache->read('cache_plugin_builder.tmp');

        if(empty($data)) {

            $data['settings'] = $this->getInfo($info);

            $this->cache->write('cache_plugin_builder.tmp', $data);
        }

        return $data;
    }
}