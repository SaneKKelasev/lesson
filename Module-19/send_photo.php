<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="send_photo.php" method="post" enctype="multipart/form-data">
    <div>
        <input type="file" name="photo">
    </div>
    <div>
        <button type="submit">Отправить</button>
    </div>
</form>
</body>
</html>

<?php
session_start();
var_dump($_FILES['photo']);

if (! isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
} elseif ($_SESSION['count'] >= 1) {
    echo 'Больше нельзя отправлять файлы';
} else {
    if (strlen($_FILES['photo']["name"] > 0 &&
        ($_FILES['photo']["type"] === 'image/jpeg' || $_FILES['photo']["type"] === 'image/png') &&
        $_FILES['photo']["size"] <= 2097152)) {
        try {
            move_uploaded_file($_FILES["photo"]["tmp_name"], './images/' . $_FILES["photo"]["name"]);
            $_SESSION['count']++;
            header("Location: images/{$_FILES["photo"]["name"]}");
        } catch (Exception $e) {
            $e->getMessage();
        }
    } else {
        echo "Ошибка загрузки файла";
    }
}

$count = $_SESSION['count'];
?>

