<?php

if(isset($_POST['ajaxSettings']) and isset($_POST['ajaxMethod'])) {

    require_once $_SERVER['DOCUMENT_ROOT'] . '/application/core/Model.php';

    $settings = explode(':',$_POST['ajaxSettings']);

    if($settings[0] == 'plugins') {

        require_once $_SERVER['DOCUMENT_ROOT'] . '/plugins/' . $settings[1] . '/models/AjaxModel.php';
        $path = '\plugins\\' . $settings[1] . '\models\AjaxModel';
    }

    new $path;
} else {
    header('location: /');
}