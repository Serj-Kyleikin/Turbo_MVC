<?

namespace application\models;

use application\core\Model;
use PDO;

class MainModel extends Model {

    // Главная страница

    public function getMain($info) {

        // Вакансии

        try {

            $getVacancys = $this->connection->prepare('SELECT * FROM site_jobs');
            $getVacancys->execute();

            return $data = $getVacancys->fetchAll(PDO::FETCH_ASSOC);

        } catch(\PDOException $e) {
            logError($e, 1);
        }
    }
}