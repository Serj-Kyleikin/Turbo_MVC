<?

namespace application\models;

use application\core\Model;
use PDO;

class MainModel extends Model {

    // Главная страница

    public function getMain($info) {

        $result['pagination'] = $this->setPagination($info['url'], $info['pagination']);

        $from = ($info['pagination'] == 1) ? 0 : ($info['pagination'] - 1) * $this->pagination;

        // Вакансии

        try {

            $getVacancys = $this->connection->prepare('SELECT * FROM site_jobs ORDER BY id DESC LIMIT :from, :limit');
 
            $getVacancys->bindValue(':from', $from, PDO::PARAM_INT);
            $getVacancys->bindValue(':limit', $this->pagination, PDO::PARAM_INT); 

            $getVacancys->execute();
            $result['static'] = $getVacancys->fetchAll(PDO::FETCH_ASSOC);

        } catch(\PDOException $e) {
            logError($e, 1);
        }

        if($result['static']) {

            // Поиск первой вакансии из БД в выдаче

            try {

                $getId = $this->connection->prepare('SELECT id FROM site_jobs ORDER BY id LIMIT 1');
                $getId->execute();
                $min = $getId->fetch(PDO::FETCH_ASSOC);

            } catch(\PDOException $e) {
                logError($e, 1);
            }

            foreach($result['static'] as $job) if($job['id'] == $min['id']) $result['pagination']['next'] = false;

        } else {

            if(!$from) $result['pagination']['next'] = false;       // Нет записей для первой страницы в пагинации
            else $result['static']['empty'] = true;                 // Отсутствуют данные для пагинации
        }

        return $result;
    }

    // Динамичный контент главной страницы

    public function getMainDynamic($options) {



    }
}