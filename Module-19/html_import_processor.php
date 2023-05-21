<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forma</title>
</head>
<body>
    <form action="./html_import_processor.php" method="post">
        <label>Ведите URL-адрес: <input type="text" name="url"></label>
        <button  type="submit">Получить</button>
    </form>

    <?php

    $curl = curl_init();

    if (isset($_POST['url'])) {
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $_POST['url'],
        ]);

        $textURL = curl_exec($curl);
        $textURL = mb_convert_encoding($textURL, "utf-8", "auto");
        $textURLJSON = json_encode(['raw_text' => $textURL], JSON_FORCE_OBJECT);
        curl_close($curl);

        if (!empty($textURLJSON)) {
            $curlTwo = curl_init();

            curl_setopt_array($curlTwo, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $textURLJSON,
                CURLOPT_URL => 'http://module-19/HtmlProcessor.php'
            ]);

            try {
                $text = curl_exec($curlTwo);
                curl_close($curlTwo);
                echo $text;
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
    }
    ?>
</body>
</html>