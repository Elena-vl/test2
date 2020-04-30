<?php


namespace Users;

include_once __DIR__ . '/LoggerInterface.php';
include_once __DIR__ . '/Logger.php';
use Log\Logger;

class User
{
    /**
     * Получение списка пользователей
     * @return array
     */
    public function index()
    {
        return (new UsersRepository(new Logger()))->userList();
    }

    /**
     * Соохранение/обновление пользователей
     * @param $param
     * @return array
     */
    public function save(array $param)
    {
        $error = [];
        if(empty($param['name']))
            $error[] = "Заполните имя пользователя";
        if(empty($param['email']))
            $error[] = "Заполните email пользователя";
        if(!empty($param['email']) && !filter_var($param['email'], FILTER_VALIDATE_EMAIL))
            $error[] = "E-mail адрес указан неверно";
        if(empty($error)) {
            $model = new UsersRepository(new Logger());
            if(isset($param['id']) && !empty($param['id']))
                return $model->userUpdate(['name' => $param['name'], 'last_name'=>$param['last_name'] ?? '', 'email'=>$param['email'] ?? '', 'id' => $param['id']]);
            else
                return $model->userAdd(['name' => $param['name'], 'last_name'=>$param['last_name'] ?? '', 'email'=>$param['email'] ?? '']);
        } else {
            return ['success' => false, 'message' => implode(".\n", $error)];
        }
    }

    /**
     * Удаление пользователей
     * @param $id
     * @return array
     */
    public function delete(int $id)
    {
        if(empty($id)) {
            return ['success' => false, 'message' => "Не указан ID"];
        }
        (new UsersRepository(new Logger()))->userDelete($id);
        return ['success' => true, 'message' => "Пользователь удален."];
    }

    /**
     * Получение информации о пользователе по $id
     * @param $id
     * @return array
     */
    public function userGetById(int $id)
    {
        $model = new UsersRepository(new Logger());
        if( $answer = $model->userGetById($id) ) {
            return ['success' => true, 'message' => $answer];
        } else {
            return ['success' => false, 'message' => "Данные о пользователе не найдены"];
        }
    }
}
