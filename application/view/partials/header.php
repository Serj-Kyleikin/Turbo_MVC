<header>
<h1><?php echo $page['settings']['h1']; ?></h1>
    <p><?php echo $page['settings']['annotation']; ?></p>
    <ul>
        <li><a class="menu_main" href="/">Главная</a></li>
        <? if(isset($_COOKIE['name'])): ?>
            <li><a class='menu_user' href='cabinet'><span>Кабинет</span></a></li>
        <? else: ?>
            <li><a class='menu_user' href='authorization'><span>Авторизация</span></a></li>
        <? endif; ?>
    </ul>
</header>