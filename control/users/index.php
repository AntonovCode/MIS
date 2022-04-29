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
        <script src="script.js" type="module" defer></script>
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
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Логин</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr data-userid=\"${row['id']}\">";
                            echo "<td>" . $row["rn"] . "</td>";
                            echo '<td data-field="surname">' . $row["surname"] . "</td>";
                            echo '<td data-field="firstname">' . $row["firstname"] . "</td>";
                            echo '<td data-field="lastname">' . $row["lastname"] . "</td>";
                            echo '<td data-field="username">' . $row["username"] . "</td>";
                            echo "<tr>";
                        }
                    ?>
                    </tbody>
                </table>
                <div class="context-menu">
                    <div data-table-popup-btn="refresh">
                        <img src="images/refresh.svg">
                        <span>Обновить</span>
                    </div>
                    <div data-table-popup-btn="update">
                        <img src="images/edit.svg">
                        <span>Редактировать</span>
                    </div>
                    <div data-table-popup-btn="delete">
                        <img src="images/delete.svg">
                        <span>Удалить</span>
                    </div>
                </div>
                <div class="popup-fade">
                    <div class="popup">
                        <h3>Редактировать данные</h3>
                        <label>
                            <div>Фамилия</div>
                            <input class="default-input-outline" name="surname"   type="text">
                        </label>
                        <label>
                            <div>Имя</div>
                            <input class="default-input-outline" name="firstname" type="text">
                        </label>
                        <label>
                            <div>Отчество</div>
                            <input class="default-input-outline" name="lastname"  type="text">
                        </label>
                        <label>
                            <div>Логин</div>
                            <input class="default-input-outline" name="username"  type="text">
                        </label>
                        <div class="popup-buttons">
                            <button class="btn-flat">Отмена</button>
                            <button class="btn-flat">Изменить</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>