<?php

/**
 * Главная страница в админпанели
 */
class AdminController extends AdminBase
{
    /**
     * Action глваной страници админпанели
     * @return bool
     */
    public function actionIndex()
    {
        // Проверка доступа вернет true или отсановит скрипт и вид не подключется
        self::checkAdmin();

        require_once (ROOT . '/views/admin/index.php');

        return true;
    }
}