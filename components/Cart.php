<?php


class Cart
{
    /**
     * @param int $productId
     * @return int : кол-во товаров в корзине
     */
    public static function addProduct(int $productId)
    {
        $productId = intval($productId);

        //Пустой массив для товаров в корзине
        $productsInCart = [];

        // Если в корзине уже есть товар (в сессии)
        if (isset($_SESSION['products'])) {
            // то заполняем наш массив товарами
            $productsInCart = $_SESSION['products'];
        }

        // Если товар есть в корзине, но был добавлен еще раз
        // увеличиваем кол-во
        if (array_key_exists($productId, $productsInCart)) {
            $productsInCart[$productId]++;
        } else {
            $productsInCart[$productId] = 1;
        }

        // запишем в сессиию массив с товарами
        $_SESSION['products'] = $productsInCart;

        return self::countItems();
    }

    /**
     * Подсчет кол-ва товаров в корзине (в сессии)
     * @return int
     */
    public static function countItems() : int
    {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id =>$quantity) {
                $count += $quantity;
            }
            return $count;
        }

        return 0;
    }

    /**
     * @return false|mixed
     */
    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
        /*
        [1]=>1 (id => кол-во)
        [16]=>2
        [5]=>8
        [9]=>3
        */
            return $_SESSION['products'];
        }

        return false;
    }

    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        if ($productsInCart) {
            $total = 0;
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }

    /**
     * Обнуляет корзину
     */
    public static function clear() : void
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

    /**
     * Удаляет товар из корзины по его id
     * @param int $productId
     */
    public static function deleteProduct(int $productId) : void
    {
        $productsInCart = self::getProducts();
        unset($productsInCart[$productId]);
        $_SESSION['products'] = $productsInCart;
    }
}