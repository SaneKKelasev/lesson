<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forma</title>
    <style>
        .container {
            width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form__item {
            width: 300px;
            margin-bottom: 20px;
        }

        .form__item input,
        .form__item textarea {
            width: 100%;
            height: 25px;
            border-radius: 10px;
            border: 1px solid black;
        }

        .form__item textarea {
            margin-bottom: -5px;
            height: 60px;
        }

        .form__submit {
            text-align: center;
        }

        .form__submit > button {
            width: 200px;
            height: 30px;
            border-radius: 20px;
            border: 1px solid greenyellow;
            background-color: #3f2aff;
            color: #f6f7f9;
        }

        .error {
            border: 2px solid red;
        }

        div.error {
            margin-bottom: 10px;
            height:50px;
            color: red;
        }

        .success {
            border: 2px solid greenyellow;
        }

        div.success {
            margin-bottom: 10px;
            height:50px;
            color: green;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="" method="post">
        <div class="form__item">
            <input type="text" name="author" placeholder="Автор">
        </div>
        <div class="form__item">
            <textarea name="text" placeholder="Текст"></textarea>
        </div>
        <div class="form__item">
            <input type="email" name="email" placeholder="email">
        </div>
        <div class="form__submit">
            <button type="submit">Отправить</button>
        </div>
    </form>
</div>
</body>
</html>
