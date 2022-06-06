<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="HandheldFriendly" content="True">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.6, user-scalable=yes">
    <title><? echo $page['settings']['title']; ?></title>
    <meta name="description" content="<? echo $page['settings']['description']; ?>">
    <link rel="stylesheet" href="<? echo $page['styles']['header']; ?>">
    <link rel="stylesheet" href="<? echo $page['styles']['content']; ?>">
</head>
<body>
    <div class="wrapper">

        <!-- Загрузка компонентов страницы-->

        <? foreach($page['partials'] as $module): ?>
            <? if($module != ''): include $module; endif; ?>
        <? endforeach; ?>

        <!-- Загрузка скриптов JS -->

        <? if(isset($page['scripts'])): ?>
            <? foreach($page['scripts'] as $script): ?>
                <? echo "<script async defer src='" . $script . "'></script>"; ?>
            <? endforeach; ?>
        <? endif; ?>

    </div>

</body>
</html>