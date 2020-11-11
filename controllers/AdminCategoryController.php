<?php

/**
 * Class AdminCategoryController
 * Управление категориями в админпанели
 */
class AdminCategoryController extends AdminBase
{
    /**
     * Страница управления категориями
     * @return bool
     */
    public function actionIndex() : bool
    {
        // Проверка доступа
        self::checkAdmin();

        // Получаем список всех категорий из бд
        $categoriesList = Category::getCategoriesListAdmin();

        require_once (ROOT . '/views/admin_category/index.php');

        return true;
    }

    /**
     * Action для добавления категории
     * @return mixed : bool||void
     */
    public function actionCreate() : bool
    {
        self::checkAdmin();

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена, получаем из нее данные
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // Флаг ошибки в форме
            $errors = false;

            // Валидация формы
            if (!isset($name) || empty($name)) {
                $errors[] = 'Заполните поле';
            }

            if (!$errors) {
                // Если ошибок при проверке формы нет, то добавляем новую категорию
                Category::createCategory($name, $sortOrder, $status);

                // Перенаправляем пользователя на страницу управления категориями
                header('Location: /admin/category');
            }
        }

        require_once (ROOT . '/views/admin_category/create.php');
        return true;
    }

    /**
     * Action для редактирования категории
     * @param int $id
     * @return mixed : bool||void
     */
    public function actionUpdate(int $id)
    {
        // Проверка доступа
        self::checkAdmin();

        // Получаем данные о конкретной категории
        $category = Category::getCategoryById($id);

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // Сохраняем изменения
            Category::updateCategoryById($id, $name, $sortOrder, $status);

            // Перенаправляем пользователя на страницу управлениями категориями
            header("Location: /admin/category");
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_category/update.php');
        return true;
    }

    /**
     * Action для удаления категории
     * @param $id
     * @return mixed : bool||void
     */
    public function actionDelete($id)
    {
        // Проверка доступа
        self::checkAdmin();

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Удаляем категорию
            Category::deleteCategoryById($id);

            // Перенаправляем пользователя на страницу управлениями товарами
            header("Location: /admin/category");
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_category/delete.php');

        return true;
    }
}