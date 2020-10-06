<?php
//function __autoload($className) // Deprecated: __autoload() is deprecated, use spl_autoload_register()
spl_autoload_register(
    function($className)
    {
        $array_path = [
            '/models/',
            '/components/'
        ];

        foreach ($array_path as $path) {
            $path = ROOT . $path . $className . '.php';
            if (is_file($path)) {
                require_once $path;
            }
        }
    }
);