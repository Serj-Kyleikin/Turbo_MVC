<?

namespace application\models;

use application\core\Model;
use PDO;

class MainModel extends Model {

    // Главная страница

    public function getMain($route, $plugin) {

        $info = $this->cache->read('cache_page_main.tmp');

        if(empty($info)) {

            $info['settings'] = $this->getInfo($route, $plugin);

            // Вакансии

            $getVacancys = $this->connection->prepare('SELECT * FROM site_jobs');
            $getVacancys->execute();

            $info['content']['vacancys'] = $getVacancys->fetchAll(PDO::FETCH_ASSOC);

            $this->cache->write('cache_page_main.tmp', $info);
        }

        return $info;
    }
}