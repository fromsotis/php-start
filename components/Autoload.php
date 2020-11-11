<?php
//function __autoload($className) // Deprecated: __autoload() is deprecated, use spl_autoload_register()
spl_autoload_register(
    function($className)
    {
        // Массив папок, в которых могут находиться необходимые классы
        $array_path = ['/models/', '/components/', '/controllers/'];

        foreach ($array_path as $path) {
            // Формируем имя и путь к файлу с классом
            $path = ROOT . $path . $className . '.php';
            // Если такой файл существует, подключаем его
            if (is_file($path)) {
                require_once $path;
            }
        }
    }
);