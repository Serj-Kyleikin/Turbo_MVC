<?php

return [

    'core' => [
        "CREATE TABLE IF NOT EXISTS settings_pages (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            name VARCHAR(100), 
            title VARCHAR(100), 
            description varchar(100), 
            h1 varchar(100), 
            annotation varchar(100), 
            scripts varchar(100)
        );"
    ],
    'plugins' => [
        "CREATE TABLE IF NOT EXISTS settings_plugins (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            plugin_name VARCHAR(100), 
            name VARCHAR(100) NULL, 
            title VARCHAR(100) NULL, 
            description varchar(100) NULL, 
            h1 varchar(100) NULL, 
            annotation varchar(100) NULL, 
            scripts varchar(100) NULL
        );",
        "CREATE TABLE IF NOT EXISTS plugin_users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            admin_login VARCHAR(100), 
            admin_password VARCHAR(100), 
            admin_password_hash VARCHAR(100), 
            personal_id integer(100), 
            secret varchar(100), 
            attempts integer(100) NULL, 
            date timestamp NULL
        );",
        "CREATE TABLE IF NOT EXISTS plugin_formBuilder_forms (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            name VARCHAR(100), 
            code TEXT
        );"
    ],
    'content' => [
        "CREATE TABLE IF NOT EXISTS site_jobs (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            text VARCHAR(100), 
            salary VARCHAR(100), 
            name VARCHAR(100), 
            worktime varchar(100)
        );"
    ]
];