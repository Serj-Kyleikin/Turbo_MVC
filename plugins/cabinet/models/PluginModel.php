<?php

namespace plugins\cabinet\models;

use application\core\Model;
use PDO;

class PluginModel extends Model {

    // Кабинет

    public function getCabinet($info) {

        // Настройка страниц

        try {

            $getPages = $this->connection->prepare('SELECT * FROM settings_pages');
            $getPages->execute();

            $result['static']['pages'] = $getPages->fetchAll(PDO::FETCH_ASSOC);

            // Вакансии

            $getVacancys = $this->connection->prepare('SELECT * FROM site_jobs');
            $getVacancys->execute();

            $result['static']['vacancys'] = $getVacancys->fetchAll(PDO::FETCH_ASSOC);

        } catch(\PDOException $e) {
            logError($e, 1);
        }

        return $result;
    }
}