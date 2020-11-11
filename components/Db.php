<?php

class Db
{
    /**
     * Получаем из db_params.php данные для подкл. к БД в виде массива
     * @return object : Возвращаем объект подключения к БД $dbh
     */
    public static function getConnection() : object
    {
        $paramPath = ROOT . '/config/db_params.php';

        $params = require($paramPath);
        // Если указать require_once($paramPath), то ошибка:
        // Fatal error: Uncaught PDOException: SQLSTATE[HY000] [2002] No such file or directory in /var/www/html/components/Db.php on line 18

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $user = $params['user'];
        $password = $params['password'];
        $dbh = new PDO($dsn, $user, $password);

        $dbh->exec("set names utf8");

        return $dbh;
    }
}