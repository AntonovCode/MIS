<?php
session_start();

if (empty($_SESSION['isAuth'])) {
    header('Location: /authorization/login/');
    exit;
}
?>
<!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>МИС</title>
        <link rel="stylesheet" href="main/style.css">
        <link rel="stylesheet" href="includes/header/style.css">
        <script src="includes/header/script.js" defer></script>
    </head>
    <body>
        <?php include "includes/header/header.php" ?>

        <main class="content">
            Тестовое содержимое
        </main>
    </body>
</html>