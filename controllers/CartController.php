<?php


class CartController
{
    // /cart/add/2
    /**
     * Action добавляет товар в корзину
     * и перенаправляет пользователя на страницу с которой он пришел
     * @param int $productId
     */
    public function actionAdd(int $productId) : void
    {
        // Добавляем товар в корзину (в сессию)
        Cart::addProduct($productId);

        // Возвращаем пользователя на старницу с которой он пришёл
        // Например со страници /catalog/
        // $_SERVER['HTTP_REFERRER'] = http://localhost/catalog/
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
        exit();
    }

    /**
     * Action добавляет товары в карзину при помощи AJAX
     * @param $productId
     * @return bool
     */
    public function actionAddAjax($productId) : bool
    {
        // Добавляем товар в корзину
        echo Cart::addProduct($productId);
        return true;
    }

    /**
     * Action главной страници корзины
     * @return bool
     */
    public function actionIndex() : bool
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $productsInCart = false;
        // Получим данные из корзины
        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            // Получаем полную информацию о товарах для списка
            $productsIds = array_keys($productsInCart);

            $products = Product::getProductsByIds($productsIds);

            $totalPrice = Cart::getTotalPrice($products);
        }
        require_once (ROOT . '/views/cart/index.php');

        return true;
    }

    /**
     * Action оформления заказа в корзине товаров
     * @return bool
     */
    public function actionCheckout()
    {
        // Список категорий для левого меню
        $categories = Category::getCategoriesList();

        // Статус успешного выполнения заказа
        $result = false;

        // Форма отправлена?
        if (isset($_POST['submit'])) {
            // Форма отправлена? - Да
            // Считываем данные формы
            $userName = trim(strip_tags($_POST['userName']));
            $userPhone = trim(strip_tags($_POST['userPhone']));
            $userComment = trim(strip_tags($_POST['userComment']));

            // Валидация полей
            $errors = false;
            if (!User::checkName($userName)) {
                $errors[] = 'Неправелное имя';
            }
            if (!User::checkPhone($userPhone)) {
                $errors[] = 'Неправельный телефон';
            }

            // Форма заполнена корректно?
            if ($errors === false) {
                // Форма заполнено корректно? - Да
                // Сохраняем заказ в БД

                // Собираем информацию о заказе
                $productInCart = Cart::getProducts();
                if (User::isGuest()) {
                    $userId = null;
                } else {
                    $userId = User::checkLogged();
                }

                // Сохраняем заказ в БД
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productInCart);

                if ($result) {
                    // Оповещаем администратора о новом заказе
                    $message = 'http://localhost/admin/orders';
                    $subject = 'Новый заказ';
                    Email::sendMail($subject, $message);

                    // Очищаем корзину
                    Cart::clear();
                }
            } else {
                // Форма заполнена корректно? - Нет

                // Итоги: общая стоимость, кол-во товаров
                $productInCart = Cart::getProducts();
                $productIds = array_keys($productInCart);
                $products = Product::getProductsByIds($productIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        } else {
            // Форма отправлена? - Нет

            // Получаем данные из корзины
            $productInCart = Cart::getProducts();

            // В корзине есть товары?
            if ($productInCart === false) {
                // В корзине есть товары? - Нет
                // Отправляем пользователя на главную для выбора товаров
                header('Location: /');
            } else {
                // В корзине есть товары? - Да

                // Итоги: общая стоимость, кол-во товаров
                $productIds = array_keys($productInCart);
                $products = Product::getProductsByIds($productIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();

                $userName = false;
                $userPhone = false;
                $userComment = false;

                // Пользователь авторизован?
                if (!User::isGuest()) {
                    // Да, авторизован
                    // Получаем информацию о пользователе из БД по id
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);
                    // подставляем в форму
                    $userName = $user['name'];
                }
            }
        }

        require_once (ROOT . '/views/cart/checkout.php');

        return true;
    }

    public function actionDelete(int $productId)
    {
        // Удаляем товар из корзины (из сессии)
        Cart::deleteProduct($productId);

        // Возвращаем пользователя на старницу с которой он пришёл
        // /cart/
        // $_SERVER['HTTP_REFERRER'] = http://localhost/cart/
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
    }
}
