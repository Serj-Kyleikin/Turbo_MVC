<?

namespace plugins\cabinet\models;

use application\core\Model;
use PDO;

class AjaxModel extends Model {

    // Изменить данные страницы

    public function saveSettingsPages() {

        $main['id'] = 1;
        $main['title'] = $_POST['main_name'];
        $main['description'] = $_POST['main_description'];
        $main['h1'] = $_POST['main_title'];
        $main['annotation'] = $_POST['main_annotation'];

        $updateMain = $this->connection->prepare("UPDATE `settings_pages` SET title=:title, description=:description, h1=:h1, annotation=:annotation WHERE id=:id");

		$updateMain->execute($main);

        $this->cache->delete('cache_page_main.tmp');
        $this->cache->delete('cache_plugin_cabinet.tmp');
    }

    // Загрузка кнопки из БД

    public function getButton() {

        $info['name'] = $_POST['name'];

        $get = $this->connection->prepare('SELECT code FROM plugin_formBuilder_forms WHERE name=:name');
        $get->execute($info);

        $result = $get->fetch(PDO::FETCH_ASSOC);

        echo json_encode($result['code']);
    }

    // Сохранение/Изменение вакансий

    public function saveJob() {

        $job['name'] = htmlspecialchars($_POST['job_name']);
        $job['text'] = htmlspecialchars($_POST['job_text']);
        $job['salary'] = htmlspecialchars($_POST['job_salary']);
        $job['worktime'] = htmlspecialchars($_POST['job_worktime']);

        if($_POST['id'] != 'add') {
            $job['id'] = $_POST['id'];
            $sql = "UPDATE site_jobs SET name=:name, text=:text, salary=:salary, worktime=:worktime WHERE id=:id";
        } else {
            $sql = "INSERT INTO site_jobs (name, text, salary, worktime) values(:name, :text, :salary, :worktime)";
        }

        $sentVacancy = $this->connection->prepare($sql);
        $sentVacancy->execute($job);

        $this->cache->delete('cache_page_main.tmp');
        $this->cache->delete('cache_plugin_cabinet.tmp');
    }

    // Удаление вакансий

    public function deleteJob() {

        $data['id'] = $_POST['id'];
        $command = $this->connection->prepare("DELETE FROM `site_jobs` WHERE `id`=:id");
        $command->execute($data);
        
        $this->cache->delete('cache_page_main.tmp');
        $this->cache->delete('cache_plugin_cabinet.tmp');
    }
}