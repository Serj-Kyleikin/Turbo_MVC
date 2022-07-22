<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="HandheldFriendly" content="True">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.6, user-scalable=yes">
    <title><? echo $page['settings']['title']; ?></title>
    <meta name="description" content="<? echo $page['settings']['description']; ?>">

    <?php

        // Загрузка стилей CSS
 
        foreach($page['styles'] as $style) {

            if(D_MODE) {
                try {
                    if(!file_exists($style)) throw new \Exception('файл стиля: ' . $style);
                } catch(Exception $e) {
                    logError($e, 'Component', 'exit');
                }
            }

            echo "<link rel='stylesheet' href='" . $style . "'>";
        }
    ?> 
</head>
<body>
    <div class="wrapper">

        <?php

            foreach($page['partials'] as $module) if($module != '') {

                if(D_MODE) {
                    try {
                        if(!file_exists($module)) throw new \Exception('файл модуля: ' . $module);
                    } catch(Exception $e) {
                        logError($e, 'Component', 'exit');
                    } 
                }

                include_once $module;
            }

            // Загрузка скриптов JS
 
            if(isset($page['scripts'])) foreach($page['scripts'] as $script) {

                if(D_MODE) {
                    try {
                        if(!file_exists($script)) throw new \Exception('файл скрипта: ' . $script);
                    } catch(Exception $e) {
                        logError($e, 'Component', 'exit');
                    }
                }

                echo "<script async defer src='$script'></script>";
            }
        ?> 

    </div>

</body>
</html>
