<?php

namespace application\core;

class View {

    // Подготовка компонентов, стилей и скриптов страницы

    public function rendering($route, $plugin, $info) {

        // Подготовка компонентов страницы и их стилей для загрузки в каркасе

        $page['partials']['header'] = 'application/view/partials/header.php';
        $page['styles']['header'] = '/public/css/partials/header.min.css';

        // Подготовка контента страницы и его стиля для загрузки в каркасе

        if($plugin != NULL) {
            $contentPath = 'plugins/' . $plugin . '/view//';
            $stylePath =  'plugins/' . $plugin . '/styles//';
        } else {
            $contentPath = 'application/view/pages/';
            $stylePath = 'public/css/pages/';
        }

        $page['partials']['content'] = $contentPath . $route . '.php';
        $page['styles']['content'] = $stylePath . $route . '.min.css';

        // Подготовка скриптов JS для загрузки в каркасе

        if($info['settings']['scripts'] != '') {
            $scripts = explode(',', $info['settings']['scripts']);
            foreach($scripts as $script) {
                if($script != '') $page['scripts'][] = '/plugins/' . $plugin . '/scripts/' . $script;
            }
        }

        // Подготовка данных страницы

        $page['settings']['title'] = $info['settings']['title'];
        $page['settings']['description'] = $info['settings']['description'];
        $page['settings']['h1'] = $info['settings']['h1'];
        $page['settings']['annotation'] = $info['settings']['annotation'];

        // Подготовка контента страницы

        $page['content'] = $info['content'];

        // Удаление переменных из памяти

        $route = $plugin = $info = null;

        $page[] = ob_get_clean();

        // Загрузка каркаса

        include 'application/view/templates/main.php';
    }

    // Редирект

    public function redirect($url) {
		header('location: /'.$url);
		exit;
	}

    // Ошибка 404

    public function show404() {

        $page['settings']['title'] = 'Такой страницы не существует!';
        $page['settings']['description'] = 'Такой страницы не существует!';
        $page['settings']['h1'] = 'Ошибка 404!';
        $page['settings']['annotation'] = 'Такой страницы не существует!';

        $page['partials']['header'] = 'application/view/partials/header.php';
        $page['styles']['header'] = '/public/css/partials/header.min.css';

        $page['partials']['content'] = 'application/view/technical/404.php';
        $page['styles']['content'] = '/public/css/technical/main.min.css';

        $page[] = ob_get_clean();

        include 'application/view/templates/main.php';
        exit;
    }
}