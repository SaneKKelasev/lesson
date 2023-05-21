<?php

include 'User.php';

$users = new User();
$listUsers = $users->list();

if (isset($_POST['change'])) {
    $users->update($_POST, $_POST['id']);
    header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
}

if (isset($_POST['delete'])) {
    $users->delete($_POST['id']);
    header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
}

if (isset($_POST['send'])) {
    $users->create($_POST);
    header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .table td {
            padding: 0 15px 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<main>
    <h1>Список пользователей:</h1>
    <table class="table">
        <?php foreach ($listUsers as $user) : ?>
            <tr>
                <td>
                    <form action="index.php" method="post">
                        <input type="number" name="id" value="<?= $user['id'] ?>" >
                        <input type="email" name="email" value="<?= $user['email'] ?>">
                        <input type="text" name="first_name" value="<?= $user['first_name'] ?>">
                        <input type="text" name="last_name" value="<?= $user['last_name'] ?>">
                        <input type="number" name="age" value="<?= $user['age'] ?>">
                        <input type="text" value="<?= $user['date_created'] ?>">
                        <input type="submit" value="Изменить" name="change">
                        <input type="submit" value="Удалить" name="delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form action="index.php" method="post">
        <h2>Добавить пользователя:</h2>
        <label>email:*
            <input type="email" name="email" required>
        </label>
        <label>Имя:*
            <input type="text" name="first_name" required>
        </label>
        <label>Фамилия:*
            <input type="text" name="last_name" required>
        </label>
        <label>Возраст:*
            <input type="number" name="age" required>
        </label>
        <button type="submit" name="send">Добавить пользователя</button>
    </form>
</main>
</body>
</html>
