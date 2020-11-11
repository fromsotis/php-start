<?php

class Router
{
    private $routes;

    public function __construct()
    {
    // Запишем в $routes массив из файла routes.php
        $routesPath = ROOT . '/config/routes.php'; // /var/www/html/config/routes.php
        $this->routes = require_once ($routesPath);
    // $routes = ['catalog'=>'catalog/index', 'products'=>'product/view']
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
     * Анализирует запрос, сравнивает строку запроса с маршрутами,
     * определяет контроллер его action и параметры,
     * вызывает метод
     * @return void
     */
    public function run() : void
    {
    // 1 Получим строку запроса
        $uri = $this->getUri(); // product/23

    // 2 Проверим наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path) {
            // $uriPattern      => $path
            // product/([0-9]+) => product/view/$1

    // 3 Сравним присутсвует ли $uriPattern в $uri
            if (preg_match("~$uriPattern~", $uri)) {

                // Получаем внутренний путь из внешнего согласно правилу
                // $uri = product/23
                // $uriPattern = product/([0-9]+)
                // $path = product/view/$1
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                // $internalRout = 'product/view/23'

    // 4 Определим: контроллер, action, параметры
                // разбиваем 'product/view/23' на ['product', 'view', '23']
                $segments = explode('/', $internalRoute);

                // Имя контроллера
                // array_shift($segment) = получает значение первого элемента в массиве и удаляет его из массива
                $controllerName = ucfirst(array_shift($segments)) . 'Controller'; // ProductController

                // Имя метода(action)
                $actionName = 'action' . ucfirst(array_shift($segments)); // actionView

                // Параметры остатки от $segments ['23']
                $params = $segments;

    // 5 Подключим файл класс-контроллер
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                // /var/www/html/controllers/ProductController.php
                if (file_exists($controllerFile)) {
                    require_once ($controllerFile);
                }
    // 6 Создаем объект, вызвываем action
                $controllerObject = new $controllerName;

                // call_user_func_array вызовит метод $actionName с параметрами $params у объекта $controllerObject
                // $params будут переданны в action как переменные, например
                // actionView($id); $id = 23
                $result = call_user_func_array(array($controllerObject, $actionName), $params);
                // $result = (new ProductController) -> actionView(23)

                // Если метод вернет true, то обрываем цикл foreach ($this->routes as $uriPattern => $path),
                // котроый ищет совпадения между маршрутом и строкой запроса
                if ($result !== null) {
                    break;
                }
            }
        }
    }
}