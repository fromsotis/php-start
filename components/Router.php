<?php

class Router
{
    private $routes;

    public function __construct()
    {
    // Запишем в $routes массив из файла routes.php
        $routesPath = ROOT . '/config/routes.php'; // /var/www/html/config/routes.php
        $this->routes = include ($routesPath);
    // $routes = ['news'=>'news/index', 'products'=>'product/list']
    }

    /**
     * Вернет uri без '/' по краям
     * @return string
     */
    private function getUri() : string
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     * Анализирует запрос и принемает управление от front controller
     */
    public function run()
    {
    // 1 Получить строку запроса
        $uri = $this->getUri();
    // 2 Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path) {
    // 3 Сравниваем $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {
                // Получаем внутренний путь из внешнего согласно правилу
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
    // 4 определить контроллер, action, параметры
                // news/view/sport/123
                $segments = explode('/', $internalRoute); // ['news', 'view', 'sport', '123']
                // array_shift($segment) = получает значение первого элемента в массиве и удаляет его из массива
                $controllerName = ucfirst(array_shift($segments)) . 'Controller'; // NewsController
                $actionName = 'action' . ucfirst(array_shift($segments)); // actionView
                $parameters = $segments; // остатки ['sport', '123']

    // 5 Подключить файл класс-контроллер
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                // /var/www/html/controllers/NewsController.php
                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }
    // 6 Создать объект, вызвать метод (т.е. action)
                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                // actionView($param1='sport', $param2='123')
                if ($result !== null) {
                    break;
                }
            }
        }
    }
}