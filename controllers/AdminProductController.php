<?php

/**
 * controller AdminProductController
 * Управление товарами в "админке"
 */
class AdminProductController extends AdminBase
{
    /**
     * Action для страницы "Управление товарами"
     * @return bool
     */
    public function actionIndex() : bool
    {
        // Проверка доступа (авторизован ли и есть ли роль 'admin'?)
        self::checkAdmin();

        // Получение списка товаров
        $productsList = Product::getProductsList();

        // view
        require_once (ROOT . '/views/admin_product/index.php');
        return true;
    }

    /**
     * Action для удаления товара
     * @param int $id
     * @return mixed : bool||void
     */
    public function actionDelete(int $id)
    {
        // Проверка доступа (авторизован ли и есть ли роль 'admin'?)
        self::checkAdmin();

        // Обработка формы на /views/admin_product/delete.php
        if (isset($_POST['submit'])) {
            // если форма отправлена удаляем товар
            Product::deleteProductById($id);
            // Возвращаем пользователя на стр. упровления товаром, после удаления
            header('Location: /admin/product');
        }

        require_once (ROOT . '/views/admin_product/delete.php');
        return true;
    }

    /**
     * Action для создания товара
     * @return mixed : bool||void
     */
    public function actionCreate()
    {
        self::checkAdmin();

        // Получаем список категория для выподающего списка при добавлении товара
        $categoriesList = Category::getCategoriesListAdmin();

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена, получаем данные из формы
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // Флаг ошибок в форме
            $errors = false;

            // При необходимости можно валидировать значения
            if (!isset($options['name']) || empty($options['name'])) {
                $errors[] = 'Заполните поля';
            }

            if ($errors === false) {
                // Если ошибок нет добавляем новый товар
                $id = Product::createProduct($options);
                // если запись успешно добавлена
                if ($id) {
                    // Проверим загружались ли через форму изображения
                    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                        // Если загружалось, переместим его в нужную папку, дадим имя $id.jpg
                        move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/upload/images/products/' . $id . '.jpg');
                    }
                }
                // Перенаправляем пользователя на страницу управления товарами
                header('Location: /admin/product');
            }
        }
        require_once (ROOT . '/views/admin_product/create.php');
        return true;
    }

    /**
     * Action для обнавления информации о товаре
     * @param $id
     * @return mixed : bool||void
     */
    public function actionUpdate($id)
    {
        self::checkAdmin();

        // Получаем список категорий для выпадающего списка
        $categoriesList = Category::getCategoriesListAdmin();

        // Получаем данные о конкретном товаре
        $product = Product::getProductById($id);

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные о конкретном заказе
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // Сохраняем изменения
            if (Product::updateProductById($id, $options)) {

                // Если запись сохранена
                // Проверим, загружалась ли через форму изображение
                if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                    // Если загружалось, переместим его в нужную папку, дадим имя $id.jpg
                    move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/upload/images/products/' . $id . '.jpg');
                }
            }
            // Перенаправляем пользователя на страницу управления товарами
            header('Location: /admin/product');
        }

        require_once (ROOT . '/views/admin_product/update.php');
        return true;
    }
}