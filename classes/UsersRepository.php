<?php


namespace Users;

use Log\LoggerInterface;

/**
 * Класс для работы с таблицей users
 * Class UsersRepository
 * @package Users
 */
class UsersRepository
{
    protected $dbh;
    /** @var LoggerInterface */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $documentRoot = str_replace('\\', '/', realpath(dirname(__FILE__) . '/../'));
        $params = require $documentRoot . '/config/db.php';
        try {
            $this->dbh = new \PDO($params['dsn'], $params['username'], $params['password']);
        } catch (\PDOException $e) {
            file_put_contents( $documentRoot. '/all_log.log', 'Ошибка подключения к БД: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
            echo 'Ошибка подключения к БД: ' . $e->getMessage();
            exit();
        }
    }

    /**
     * Список пользователей
     * @return array
     */
    public function userList()
    {
        $sth = $this->dbh->prepare("SELECT * FROM `users` ORDER BY `id`");
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Получение пользователя по id
     * @param $id
     * @return array
     */
    public function userGetById($id)
    {
        $sth = $this->dbh->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $sth->execute(array('id' => $id));
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Добавление пользователя
     * @param $params
     * @return array
     */
    public function userAdd($params)
    {
        $sth = $this->dbh->prepare("INSERT INTO users(`name`, `last_name`, `email`) VALUES(?,?,?)");
        $sth->execute([$params['name'], $params['last_name'], $params['email']]);
        if(!empty($id = $this->dbh->lastInsertId())) {
            $this->logger->log('add');
            return ['success' => true, 'message' => $this->userGetById($id)];
        } else {
            return ['success' => false, 'message' => $sth->errorInfo()];
        }
    }

    /**
     * Обновление пользователя
     * @param $params
     * @return array
     */
    public function userUpdate($params)
    {
        try {
            $sth = $this->dbh->prepare("UPDATE `users` SET `name` = :name, `last_name` = :last_name, `email` = :email  WHERE `id` = :id");
            $sth->execute([
                'name' => $params['name'], 'last_name' => $params['last_name'], 'email' => $params['email'], 'id' => $params['id']
            ]);
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Возникла ошибка при обновлении данных'];
        }
        return ['success' => true, 'message' => $this->userGetById($params['id'])];
    }

    /**
     * Удаление пользователя
     * @param $id
     */
    public function userDelete($id)
    {
        $sth = $this->dbh->prepare("DELETE FROM `users` WHERE `id` = :id");
        $this->logger->log('delete');
        $sth->execute(array('id' => $id));
    }
}
