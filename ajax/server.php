<?
include_once __DIR__ . '/../classes/UsersRepository.php';
include_once __DIR__ . '/../classes/User.php';
use Users\User;

if (isset($_GET['delete'])) {
    $id = $_GET['id'];
    $users = new User();
    $answer = $users->delete($_GET['id']);
    echo json_encode($answer);
    exit();
}
if (isset($_POST['view'])) {
    $users = new User();
    $answer = $users->userGetById($_POST['id']);
    echo json_encode($answer);
    exit();
}
if (isset($_POST['update'])) {
    $users = new User();
    $answer = $users->save(['id' => $_POST['id'], 'name' => $_POST['name'], 'email' => $_POST['email'], 'last_name' => $_POST['last_name']]);
    echo json_encode($answer);
    exit();
}
if (isset($_POST['save'])) {
    $users = new User();
    $answer = $users->save(['name' => $_POST['name'], 'email' => $_POST['email'], 'last_name' => $_POST['last_name']]);
    echo json_encode($answer);
    exit();
}
