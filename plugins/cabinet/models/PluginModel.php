<?php

namespace plugins\cabinet\models;

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

    // Кабинет

    public function getCabinet($route, $plugin) {

        $info = $this->cache->read('cache_plugin_cabinet.tmp');

        if(empty($info)) {

            $info['settings'] = $this->getInfo($route, $plugin);

            // Настройка страниц

            $getPages = $this->connection->prepare('SELECT * FROM settings_pages');
            $getPages->execute();

            $info['content']['pages'] = $getPages->fetchAll(PDO::FETCH_ASSOC);

            // Вакансии

            $getVacancys = $this->connection->prepare('SELECT * FROM site_jobs');
            $getVacancys->execute();

            $info['content']['vacancys'] = $getVacancys->fetchAll(PDO::FETCH_ASSOC);

            $this->cache->write('cache_plugin_cabinet.tmp', $info);
        }

        return $info;
    }
}