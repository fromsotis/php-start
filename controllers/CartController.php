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
}