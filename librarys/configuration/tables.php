<?php

return [
    
  'settings_pages' => [
      ' id integer unsigned auto_increment primary key,',
      ' name varchar(100),',
      ' title varchar(100),',
      ' description varchar(100),',
      ' h1 varchar(100),',
      ' annotation varchar(100),',
      ' partials varchar(100),',
      ' scripts varchar(100),',
      ' plugins varchar(100)'
  ],
  'settings_plugins' => [
      ' id integer unsigned auto_increment primary key,',
      ' plugin_name varchar(100),',
      ' name varchar(100) NULL,',
      ' title varchar(100) NULL,',
      ' description varchar(100) NULL,',
      ' h1 varchar(100) NULL,',
      ' annotation varchar(100) NULL,',
      ' partials varchar(100) NULL,',
      ' scripts varchar(100) NULL,',
      ' plugins varchar(100) NULL'
  ],
  'site_contacts' => [
      ' id integer unsigned auto_increment primary key,',
      ' office varchar(100) NULL,',
      ' mail varchar(100)'
  ],
  'site_jobs' => [
      ' id integer unsigned auto_increment primary key,',
      ' text varchar(100),',
      ' salary varchar(100),',
      ' name varchar(100),',
      ' worktime varchar(100)'
  ],
  'plugin_users' => [
      ' id integer unsigned auto_increment primary key,',
      ' admin_login varchar(100),',
      ' admin_password varchar(100),',
      ' admin_password_hash varchar(100),',
      ' personal_id integer(11),',
      ' secret varchar(100),',
      ' attempts integer(11) NULL,',
      'date timestamp NULL'
  ],
  'plugin_formBuilder_forms' => [
    ' id integer unsigned auto_increment primary key,',
    ' name varchar(100),',
    ' code text'
    ]
];