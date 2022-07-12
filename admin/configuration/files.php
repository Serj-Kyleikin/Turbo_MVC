<?php

return [
    'core' => [
        'configurations/connection.php' => '',
        '.htaccess' => "RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php

php_value default_charset utf-8
AddType 'text/html; charset=utf-8' .html .htm .shtml

Options All -Indexes"
    ],
    'plugins' => [
        'logs/diagnostic_errors.txt' => '',
        'logs/db_errors.txt' => '',
        'logs/resourse_errors.txt' => '',
        'logs/plugins/users/authorizations.txt' => '',
        'logs/plugins/users/errors.txt' => ''
    ]
];