<?

namespace application\models;

use application\core\Model;
use PDO;

class MainModel extends Model {

    // Главная страница

    public function getMain($info) {

        $data = $this->cache->read('page_main.tmp');
        
        if(empty($data)) {

            $data['settings'] = $this->getInfo($info);

            // Вакансии

            try {

                $getVacancys = $this->connection->prepare('SELECT * FROM site_jobs');
                $getVacancys->execute();

                $data['content']['vacancys'] = $getVacancys->fetchAll(PDO::FETCH_ASSOC);

                $this->cache->write('page_main.tmp', $data);

            } catch(\PDOException $e) {
                logError($e, 1);
            }
        }

        return $data;
    }
}