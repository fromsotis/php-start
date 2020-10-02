<?php


class Db
{
    /**
     * Получаем из db_params.php данные для подкл. к БД в виде массива
     * Возвращаем подкл. к БД
     * @return object
     */
    public static function getConnection() : object
    {
        $paramPath = ROOT . '/config/db_params.php';
        $params = include ($paramPath);
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";

        return new PDO($dsn, $params['user'], $params['password']);
    }
}