<?php
require 'connect.php';
$connect = new PDO_CONNECT('localhost', 'alterra', 'root', 'root');
if (!empty($_POST) && !empty($_POST["name"]) && !empty($_POST["phone"])) {
    $connect->addTableItem('phones', $_POST);
}
if (!empty($_GET) && !empty($_GET["DELETE_ELEMENT"])) {
    $connect->deleteTableItem($_GET["DELETE_ELEMENT"], 'phones');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
    <title>Книга контактов</title>
</head>
<body>
<div class="contact-wrapper">
    <form action="/тестовое%20альтерра/" method="post" class="top-wrapper">
        <div class="title-wrap">
            <h3 class="title-top">Добавить контакт</h3>
        </div>
        <div class="input-wrapper">
            <input type="text" name="name" class="name" placeholder="Имя">
            <input type="text" name="phone" class="phone" placeholder="Телефон">
        </div>
        <button class="add-button">Добавить</button>
    </form>
    <div class="bottom-wrapper">
        <div class="title-wrap-bot">
            <h3 class="title-top">Список контактов</h3>
        </div>
        <div class="contact-wrap">
            <?php
            $data = $connect->getQueryList('phones', ['id', 'name', 'phone']);
            while ($row = $data->fetch()) {
                ?>
                <div class="contact">
                    <div class="name-contact">
                        <div class="name"><?= $row["name"] ?></div>
                        <a href="/?DELETE_ELEMENT=<?= $row["id"] ?>" class="close-btn"></a>
                    </div>
                    <div class="phone-contact">
                        <?= $row["phone"] ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>