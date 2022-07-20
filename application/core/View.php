<?php

namespace application\core;

class View {

    public $errors = [
        '0' => 'файл шаблона: '
    ];

    // Подготовка компонентов, стилей и скриптов страницы

    public function rendering($info, $data) {

        // Подготовка компонентов страницы и их стилей для загрузки в каркасе

        $page['partials']['header'] = 'application/view/partials/header.php';
        $page['styles']['header'] = 'public/css/partials/header.css';

        // Подготовка контента страницы и его стиля для загрузки в каркасе

        if(isset($info['plugin'])) {
            $contentPath = 'plugins/' . $info['plugin'] . '/view/';
            $stylePath =  'plugins/' . $info['plugin'] . '/styles/';
            $scriptPath = 'plugins/' . $info['plugin'] . '/scripts/';
        } else {
            $contentPath = 'application/view/pages/';
            $stylePath = 'public/css/pages/';
            $scriptPath = 'public/js/';
        }

        $page['partials']['content'] = $contentPath . $info['path'] . '.php';
        $page['styles']['content'] = $stylePath . $info['path'] . '.css';

        // Подготовка скриптов JS для загрузки в каркасе

        if($data['settings']['scripts'] != '') {
            $scripts = explode(',', $data['settings']['scripts']);
            foreach($scripts as $script) {
                if($script != '') $page['scripts'][] = $scriptPath  . $script;
            }
        }

        // Подготовка данных страницы

        $page['settings']['title'] = $data['settings']['title'];
        $page['settings']['description'] = $data['settings']['description'];
        $page['settings']['h1'] = $data['settings']['h1'];
        $page['settings']['annotation'] = $data['settings']['annotation'];

        // Подготовка контента страницы

        $page['content'] = $data['content'];

        // Удаление переменных из памяти

        $route = $plugin = $data = null;

        $page[] = ob_get_clean();

        // Загрузка каркаса

        $file = 'application/view/gather.php';

        if(D_MODE) {
            try {
                if(!file_exists($file)) throw new \Exception($this->errors[0] . $file);
            } catch(\Exception $e) {
                logError($e, 0);
            }
        }

        include_once $file;

        $this->errors = null;
    }
}