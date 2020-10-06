<?php
// front controller

// 1. Общие настройки
declare(strict_types=1);

ini_set('error_reporting', (string) E_ALL);
ini_set('display_errors', (string) 1);
ini_set('display_startup_errors', (string) 1);

date_default_timezone_set('Asia/Vladivostok');
setlocale(LC_ALL, "russian");

// 2. Подключение файлов системы
define('ROOT', dirname(__FILE__)); // /var/www/html
require_once (ROOT . '/components/Autoload.php'); // /var/www/html/components/Autoload.php
//require_once (ROOT . '/components/Router.php'); // /var/www/html/components/Router.php
//require_once (ROOT . '/components/Db.php'); // /var/www/html/components/Db.php

// 3. Установка соединение с БД

// 4. Вызов Router
$router = new Router();
$router->run(); // Class Router, method run()