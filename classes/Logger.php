<?php

namespace Log;


/**
 * Запись изменений пользователей
 * Class Logger
 * @package Log
 */
class Logger implements LoggerInterface
{
    protected $dbh;
    protected $type;

    public function __construct()
    {
        $documentRoot = str_replace('\\', '/', realpath(dirname(__FILE__) . '/../'));
        $params = require $documentRoot . '/config/db.php';
        try {
            $this->dbh = new \PDO($params['dsn'], $params['username'], $params['password']);
        } catch (\PDOException $e) {
            file_put_contents($documentRoot . '/all_log.log', 'Ошибка подключения к БД: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
            echo 'Ошибка подключения к БД: ' . $e->getMessage();
            exit();
        }
    }

    public function log($type) {
        $this->type = $type;
        if($data = $this->currentDate()) {
            $this->updateRow($data['count']);
        } else {
            $this->addRow();
        }
    }

    /**
     * Проверка наличия записи за текущий день
     * @return mixed
     */
    private function currentDate() {
        $sth = $this->dbh->prepare("SELECT `count` FROM `changes` WHERE `date` = :date AND `type` = :type");
        $sth->execute([
            'date' => date("Y-m-d 00:00:00"), 'type'=> $this->type
        ]);
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Добавление записи
     */
    private function addRow()
    {
        $sth = $this->dbh->prepare("INSERT INTO `changes` SET `count` = :count, `date` = :date, `type` = :type");
        $sth->execute([
            'date' => date("Y-m-d 00:00:00"), 'type'=> $this->type, 'count' => 1
        ]);
    }

    /**
     * Обновление записи
     * @param $count
     */
    private function updateRow(int $count)
    {
        $sth = $this->dbh->prepare("UPDATE `changes` SET `count` = :count WHERE `date` = :date AND `type` = :type");
        $sth->execute([
            'date' => date("Y-m-d 00:00:00"), 'type'=> $this->type, 'count' => $count+1
        ]);
    }

    /**
     * Получение списка записей на заданную дату
     * @param $date
     * @return mixed
     */
    public function listLog(string $date)
    {
        $sth = $this->dbh->prepare("SELECT `date`, `type`, `count` FROM `changes` WHERE `date` = :date");
        $sth->execute([
            'date' => $date
        ]);
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }
}
