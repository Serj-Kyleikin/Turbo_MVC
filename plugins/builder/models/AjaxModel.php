<?

namespace plugins\builder\models;

use application\core\Model;
use PDO;

class AjaxModel extends Model {

    // Проверка имени создаваемой формы

    public function checkName() {

        $prepare['name'] = $_POST['name'];
        $type = $_POST['type'];

        try {

            $query = "SELECT id FROM plugin_formBuilder$type WHERE name=:name";
            $check = $this->connection->prepare($query);
            $check->execute($prepare);

            $row = $check->fetch(PDO::FETCH_ASSOC);

        } catch(\PDOException $e) {
            $this->log->logErrors($e, 1);
        }

        echo ($row['id'] != '') ? 'wrong' : 'clear';
    }

    // Изменить данные страницы

    public function addForm() {

        // Создание таблицы для хранения записей формы

        $query = "CREATE TABLE IF NOT EXISTS plugin_formBuilder_forms_" . $_POST['name'] . "(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";

        $fields = '';

        foreach(explode(',', trim($_POST['fields'], ',')) as $field) {
            $field = explode('___', $field);
            $type = ($field[1] == 'input') ? 'VARCHAR(100)' : 'TEXT';
            $str = $field[0] . ' ' . $type . ", ";
            $fields .= $str;
        }

        $query .= trim($fields, ', ') . ")";

        try {
            $create = $this->connection->prepare($query);
            $create->execute();
        } catch(\PDOException $e) {
            $this->log->logErrors($e, 1);
        }

        // Внесение кнопки

        $data['name'] = $_POST['name'];
        $data['code'] = $_POST['button'];

        $sql = "INSERT INTO plugin_formBuilder_forms (name, code) VALUES(:name, :code)";

        try {
            $sentVacancy = $this->connection->prepare($sql);
            $sentVacancy->execute($data);
        } catch(\PDOException $e) {
            $this->log->logErrors($e, 1);
        }
    }
}