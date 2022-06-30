<?php

// \$ - экранирование

return [

    "INSERT INTO plugin_users(
            id, 
            admin_login, 
            admin_password, 
            admin_password_hash, 
            personal_id, 
            secret
    ) VALUES(
            '1', 
            'admin', 
            'admin', 
            '$2y$10\$UxZi4pfbxXAoyiawbL4dteGxxtnrjcUYPiNGf0gEUC5nuCW4JrX16', 
            '177592', 
            '5cc4ff6af2cae5fcca36d79aa3b4'
    )",
    "INSERT INTO settings_pages(
            id, 
            name, 
            title, 
            description, 
            h1, 
            annotation
    ) VALUES(
            '1', 
            'main', 
            'Главная страница сайта', 
            'Описание главной страницы сайта', 
            'Заголовок страницы', 
            'Добро пожаловать на сайт'
    )",
    "INSERT INTO settings_plugins(
            id, 
            plugin_name, 
            name, 
            title, 
            description, 
            h1, 
            annotation, 
            scripts
    ) VALUES(
            '1', 
            'cabinet', 
            'cabinet', 
            'Кабинет пользователя', 
            'Описание кабинета пользователя', 
            'Кабинет пользователя', 
            'Добро пожаловать!', 
            'cabinet.min.js,'
    )",
    "INSERT INTO settings_plugins(
            id, 
            plugin_name, 
            name, 
            title, 
            description, 
            h1, 
            annotation, 
            scripts
    ) VALUES(
            '2', 
            'users', 
            'authorization', 
            'Страница авторизации', 
            'Описание страницы авторизации', 
            'Кабинет пользователя', 
            'Добро пожаловать!', 
            'users.min.js,'
    )",
    "INSERT INTO site_contacts(
            id, 
            office, 
            mail
    ) VALUES(
            '1', 
            'admin', 
            'admin@domain.site'
    )"
];