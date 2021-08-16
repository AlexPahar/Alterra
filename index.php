<?php
session_start();
require_once "api/config/database.php";
require_once "api/objects/phones.php";

$database = new Database();
$db = $database->getConnection();

$phones = new Phones($db);
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
    <form action="/" method="post" class="top-wrapper">
        <div class="title-wrap">
            <h3 class="title-top">Добавить контакт</h3>
        </div>
        <div class="input-wrapper">
            <input type="text" name="name" class="name" placeholder="Имя">
            <input type="text" id="phone" name="phone" class="phone" placeholder="Телефон">
        </div>
        <button class="add-button">Добавить</button>
    </form>
    <div class="bottom-wrapper">
        <div class="title-wrap-bot">
            <h3 class="title-top">Список контактов</h3>
        </div>
        <div class="contact-wrap">
            <?php
            $data = $phones->read();
            while ($row = $data->fetch()) {
                ?>
                <div class="contact">
                    <div class="name-contact">
                        <div class="name"><?= $row["name"] ?></div>
                        <div data-id="<?= $row["id"] ?>" class="close-btn"></div>
                    </div>
                    <div class="phone-contact">
                        <?= $row["phone"] ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
    <script src="js/inputmask.min.js"></script>
    <script src="js/form.js"></script>
</body>
</html>