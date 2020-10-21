<?php


class CartController
{
    // /cart/add/2
    public function actionAdd(int $productId)
    {
        // Добавляем товар в корзину (в сессию)
        Cart::addProduct($productId);

        // Возвращаем пользователя на старницу с которой он пришёл
        // Например со страници /catalog/
        // $_SERVER['HTTP_REFERRER'] = http://localhost/catalog/
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
    }

    public function actionAddAjax($productId)
    {
        // Добавляем товар в корзину
        echo Cart::addProduct($productId);
        return true;
    }

    public function actionIndex()
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

    public function actionCheckout()
    {
        // Список категорий для левого меню
        $categories = [];
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
                    $adminMail = 'womxez09hez2@mail.ru';
                    $message = 'http://localhost/admin/orders';
                    $subject = 'Новый заказ';

                    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                        ->setUsername('fromyeticave@gmail.com')
                        ->setPassword('!@Qw123456789');

                    $mailer = new Swift_Mailer($transport);

                    $message = (new Swift_Message($subject))
                        ->setFrom(['fromyeticave@gmail.com' => 'E-Shopper'])
                        ->setTo([$adminMail])
                        ->setBody($message, 'text/html');
                    // Debug send mail
//                    $logger = new Swift_Plugins_Loggers_EchoLogger();
//                    $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
//
//                    $result = $mailer->send($message, $failures);
//                    var_dump($failures);

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
                if (User::isGuest()) {
                    // Нет
                    // Для формы пустые
                } else {
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
