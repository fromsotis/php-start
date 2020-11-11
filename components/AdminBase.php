<?php


abstract class AdminBase
{
    /**
     * Проверяем, авторизован ли пользователь
     * Проверяем у пользователя наличие роли 'admin'
     * @return bool|void
     */
    public static function checkAdmin()
    {
        // Проверяем авторизован ли пользователь.
        // Присовем (int)id пользователя или перенаправим на login.php
        $userId = User::checkLogged();

        // Получаем инфу о текущем пользователе
        $user = User::getUserById($userId);

        // Если роль 'admin' вернем true
        if ($user['role'] === 'admin') {
            return true;
        }
        // иначе остановим скрипт и выведм 'Access denied'
        die('Access denied');
    }
}