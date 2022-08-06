<?php

return [

    'core' => [
        "CREATE TABLE IF NOT EXISTS settings_pages (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            name VARCHAR(100), 
            title NVARCHAR(50), 
            description NVARCHAR(100), 
            h1 NVARCHAR(100), 
            annotation NVARCHAR(100), 
            scripts VARCHAR(100)
        );",
        "CREATE TABLE IF NOT EXISTS icons (
            type VARCHAR(20), 
            page VARCHAR(50) NULL, 
            name NVARCHAR(50), 
            image TEXT, 
            description VARCHAR(200) NULL
        );"
    ],
    'plugins' => [
        "CREATE TABLE IF NOT EXISTS settings_plugins (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            plugin_name VARCHAR(100), 
            name VARCHAR(100) NULL, 
            title NVARCHAR(50) NULL, 
            description NVARCHAR(100) NULL, 
            h1 NVARCHAR(100) NULL, 
            annotation NVARCHAR(100) NULL, 
            scripts VARCHAR(100) NULL
        );",
        "CREATE TABLE IF NOT EXISTS plugin_users_registered (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
            login VARCHAR(100), 
            password VARCHAR(100), 
            password_hash VARCHAR(100)
        ) ENGINE = InnoDB;",
        "CREATE TABLE IF NOT EXISTS plugin_users_secure (
            user_id INTEGER(10) UNSIGNED NOT NULL, 
            secret VARCHAR(30), 
            attempts TINYINT(1) NULL, 
            date TIMESTAMP NULL, 
            FOREIGN KEY (user_id) REFERENCES plugin_users_registered (id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE = InnoDB;",
        "CREATE TABLE IF NOT EXISTS plugin_users_personal (
            user_id INTEGER(10) UNSIGNED NOT NULL, 
            name NVARCHAR(50), 
            mail VARCHAR(30), 
            FOREIGN KEY (user_id) REFERENCES plugin_users_registered (id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE = InnoDB;",
        "CREATE TABLE IF NOT EXISTS plugin_formBuilder_forms (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            name VARCHAR(100), 
            code TEXT
        );"
    ],
    'content' => [
        "CREATE TABLE IF NOT EXISTS site_jobs (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            text TEXT, 
            salary VARCHAR(100), 
            name VARCHAR(100), 
            worktime varchar(100)
        );"
    ]
];