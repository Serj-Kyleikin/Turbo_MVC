<?

namespace plugins\users\models;

use application\core\Model;
use PDO;

class AjaxModel extends Model {

    // Авторизация

    public function authorization() {
		$row = $this->getUser();
        echo (!empty($row)) ? $this->checkPassword($row) : 'wrong_Login';
    }

    // Получение данных пользователя

    public function getUser() {

        $data['admin_login'] = htmlspecialchars($_POST['login']);

        try {
            $request = $this->connection->prepare("SELECT personal_id, admin_password_hash, attempts, date FROM plugin_users WHERE admin_login=:admin_login");
            $request->execute($data);

            return $request->fetch(PDO::FETCH_ASSOC);

        } catch(\PDOException $e) {
            $this->log->logErrors($e, 1);
        }
    }

    // Проверка пароля

    public function checkPassword($row, $status = []) {

        if($row['attempts'] == 2 and $status != 'retry') {
            $response = $this->checkAttempts($row);
        } else {
            $response = (password_verify($_POST['password'], $row['admin_password_hash'])) ? 'verify' : 'wrong_Password';
        }

        if($response == 'wrong_Password') {

            $response = ($status == 'retry') ? $this->updateAttempts(1, '2') : $this->checkAttempts($row);

        } elseif($response == 'verify') {

            $prepare['admin_login'] = htmlspecialchars($_POST['login']);
            $prepare['secret'] = bin2hex(random_bytes(14));
            $prepare['attempts'] = null;
            $prepare['date'] = null;

            try {

                $insert = $this->connection->prepare("UPDATE `plugin_users` SET secret=:secret, attempts=:attempts, date=:date WHERE admin_login=:admin_login");
                $insert->execute($prepare);

            } catch(\PDOException $e) {
                $this->log->logErrors($e, 1);
            }

            $public_key = $row['personal_id'] . '_' . $prepare['secret'];

            setcookie('admin', $public_key, time()+60*60*24*365*1, '/');

            if($_POST['info'] == '"TypeError"') {
                $log = 'Сайт https://json.geoiplookup.io/ работает с ошибкой, поэтому данные авторизующегося пользователя не получить.';
                $code = 1;
            } else {
                $log = $_POST['info'];
                $code = 0;
            }

            $this->log->logPlugin($log, $code);
        }

        return $response;
    }

    // Проверка статуса неудачной попытки

    public function checkAttempts($row) {

        if($row['attempts'] == '') {
            $response = $this->updateAttempts(1, '2');
        } else {

            if($row['attempts'] == 1) {
                $response = $this->updateAttempts(2, '1');
            } else {
                $response = (time() - strtotime($row['date']) > 3600) ? $this->checkPassword($row, 'retry') : 'password_blocked';
            }
        }

        return $response;
    }

    // Внесение неудачной попытки

    public function updateAttempts($attempts, $response) {

        $check['admin_login'] = htmlspecialchars($_POST['login']);
        $check['attempts'] = $attempts;

        try {

            $sentLimit = $this->connection->prepare("UPDATE `plugin_users` SET attempts=:attempts, date=NOW() WHERE admin_login=:admin_login");
            $sentLimit->execute($check);

        } catch(\PDOException $e) {
            $this->log->logErrors($e, 1);
        }

        return "password_{$response}";
    }
}