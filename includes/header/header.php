<header class="header">
    <a class="logo" href="/">
        <img class="logo__img" src="/includes/header/icons/pill.svg">
        <div class="logo__text">
            <div>Медицинская</div>
            <div>Информационная</div>
            <div>Система</div>
        </div>
    </a>

    <nav class="header__nav">
        <a class="header__section" href="">Регистратура</a>
        <a class="header__section" href="">Аптека</a>
        <a class="header__section" href="">Стационар</a>
        <a class="header__section" href="">Поликлиника</a>
        <a class="header__section" href="">Склад</a>
        <a class="header__section" href="">Прием пациета</a>
        <div class="dropdown">
            <div class="header__section">Администрирование</div>
            <div class="dropdown__content">
                <a class="header__subsection" href="/control/users/">Пользователи</a>
                <a class="header__subsection" href="">Права пользователей</a>
            </div>
        </div>
    </nav>
    
    <div class="user-info">
        <div class="user-info__fio">
            <div><?php echo $_SESSION["surname"] ?></div>
            <div><?php echo $_SESSION["firstname"] ?></div>
            <div><?php echo $_SESSION["lastname"] ?></div>
        </div>
        <button title="Выйти" class="exit">
            <img class="exit__img" src="/includes/header/icons/logout.svg">
        </button>
    </div>
</header>