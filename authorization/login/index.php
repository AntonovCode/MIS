<!DOCTYPE html>

<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>МИС-авторизация</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="authorization-form">
        <div class="row">
            <div>
                <label class="login-label" for="login-input">Введите логин пользователя</label>
            </div>
            <input class="login-input" id="login-input" type="text" maxlength="50" required>    
        </div>

        <div class="row-2">
            <div>
                <label for="password-input">Введите пароль пользователя</label>
            </div>
            <input class="password-input" id="password-input" type="password" required>
        </div>

        <div>
            <button class="authorization-btn">Войти</button>
        </div>
    </div>
</body>
</html>