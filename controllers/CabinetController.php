<?php


class CabinetController
{
    /**
     * Action для главной страници личного кабинета пользователя
     * @return mixed true - подключит кабинет || void - перенаправит на login.php
     */
    public function actionIndex()
    {
        // Получим id пользователя || нас перенправит на login.php
        $userId = User::checkLogged();

        // Получаем инфу о пользователе по id
        $user = User::getUserById($userId);

        require_once (ROOT . '/views/cabinet/index.php');

        return true;
    }
}