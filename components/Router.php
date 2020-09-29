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
        //echo $uri; // news

    // 2 Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path) {
            //echo "<br>$uriPattern -> $path";
            //news -> news/index
            //products -> product/list

    // 3 Сравниваем $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {

    // 4 Если есть совпадение, определить какой контроллер и action обрабатывает  запрос
                $segments = explode('/', $path);
                // localhost/products/
                //var_dump($segments); // ['product', 'list']
                // Формируем имя контроллера и action:
                // array_shift($segment) = получает (product) - значение первого элемента в массиве и удаляет его из массива
                $controllerName = ucfirst(array_shift($segments)) . 'Controller'; // ProductController
                $actionName = 'action' . ucfirst(array_shift($segments)); // actionList

    // 5 Подключить файл класс-контроллер
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                // /var/www/html/controllers/ProductController.php
                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }
    // 6 Создать объект, вызвать метод (т.е. action)
                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName();
                if ($result !== null) {
                    break;
                }
            }
        }
    }
}