<?php
session_start();

if (empty($_SESSION['isAuth'])) {
    header('Location: /authorization/login/');
    exit;
}

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/includes/pgConnection.php";
include_once($path);

$conn = getPgConnection();
$sql = "select row_number() OVER() as RN,
               id,
               surname,
               firstname,
               lastname,
               username
          from users";
$statement = $conn->query($sql);

?>
<!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>МИС</title>
        <link rel="stylesheet" href="/main/style.css">
        <link rel="stylesheet" href="/includes/header/style.css">
        <link rel="stylesheet" href="style.css">
        <script src="/includes/header/script.js" defer></script>
        <script src="script.js" defer></script>
    </head>
    <body>
        <?php include "../../includes/header/header.php" ?>

        <main class="content">
            <section class="new-user">
                <h1>Создать пользователя</h1>
                <div id="status-message"></div>
                <div class="new-user__fields">
                    <input class="default-input" name="surname"   type="text" placeholder="Фамилия">
                    <input class="default-input" name="firstname" type="text" placeholder="Имя">
                    <input class="default-input" name="lastname"  type="text" placeholder="Отчество">
                    <input class="default-input" name="username"  type="text" placeholder="Логин">
                    <input class="default-input" name="password"  type="text" placeholder="Пароль">
                    <button id="createBtn" class="new-user__btn">Создать</button>
                </div>
            </section>

            <section>
                <h1>Найти пользователя</h1>
                <div class="search__fields">
                    <input class="default-input" name="surname"    type="text" placeholder="Фамилия">
                    <input class="default-input"  name="firstname" type="text" placeholder="Имя">
                    <input class="default-input" name="lastname"   type="text" placeholder="Отчество">
                    <input class="default-input" name="username"   type="text" placeholder="Логин">
                    <button id="findBtn" class="new-user__btn">Найти</button>
                </div>
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Логин</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row["rn"] . "</td>";
                            echo "<td>" . $row["surname"] . "</td>";
                            echo "<td>" . $row["firstname"] . "</td>";
                            echo "<td>" . $row["lastname"] . "</td>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td>" . "<button class=\"remove__btn\" data-userid=\"${row['id']}\">Удалить</button>" . "</td>";
                            echo "<tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </section>
        </main>
    </body>
</html>