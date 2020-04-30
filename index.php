<?

include_once __DIR__ . '/classes/UsersRepository.php';
include_once __DIR__ . '/classes/User.php';
include_once __DIR__ . '/classes/LoggerInterface.php';
include_once __DIR__ . '/classes/Logger.php';
use Users\User;

$users = new User();
$results = $users->index();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление пользователями</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div style="display: flex">
        <div style="width: 50%;">
            <? if(empty($results)): ?>
                <span>Данных о пользователях нет</span>
            <? else: ?>
                <table>
                    <caption>Пользователи</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Email</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?foreach ($results as $row) { ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['last_name']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td>
                                    <span class="view" data-id="<?= $row['id']?>"><i class="fa fa-eye"></i></span>
                                    <span class="edit" data-id="<?= $row['id']?>"><i class="fa fa-edit"></i></span>
                                    <span class="delete" data-id="<?= $row['id']?>"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            <? endif; ?>
        </div>
        <div style="width: 50%; text-align: right;">
            <? include('form.php'); ?>
        </div>
    </div>
</body>
<footer>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="script.js"></script>
</footer>
</html>
