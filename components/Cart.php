<?php
/**
 * Класс Cart
 * Компонент для работы корзиной
 */
class Cart
{
    /**
     * Добавление товара в корзину (сессию)
     * @param int $productId id товара
     * @return int : кол-во товаров на данный момент в корзине
     */
    public static function addProduct(int $productId)
    {
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
     * @return int : кол-во товаров || 0
     */
    public static function countItems() : int
    {
        // Проверка наличия товаров в корзине
        if (isset($_SESSION['products'])) {
            // Если массив с товарами есть
            // Подсчитаем и вернем их количество
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count += $quantity;
            }
            return $count;
        }
        // Если товаров нет, вернем 0
        return 0;
    }

    /**
     * Возвращает массив с идентификаторами и количеством товаров в корзине
     * Если товаров нет, возвращает false;
     * @return mixed : array || false
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

    /**
     * Получаем общую стоимость переданных товаров
     * @param array $products Массив с информацией о товарах
     * @return int Общая стоимость
     */
    public static function getTotalPrice(array $products) : int
    {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();
        // Подсчитываем общую стоимость
        $total = 0;
        if ($productsInCart) {
            // Если в корзине не пусто
            foreach ($products as $item) {
                // Находим общую стоимость: цена товара * количество товара
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }

    /**
     * Очищает корзину
     * @return void
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
     * @return void
     */
    public static function deleteProduct(int $productId) : void
    {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();
        // Удаляем из массива элемент с указанным id
        unset($productsInCart[$productId]);
        // Записываем массив товаров с удаленным элементом в сессию
        $_SESSION['products'] = $productsInCart;
    }
}