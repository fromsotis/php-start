<?php

class ProductController
{
    /**
     * Action для получения конкретного товара по id
     * @param int $productId
     * @return bool
     */
    public function actionView(int $productId) : bool
    {
        // Список категорий
        $categories = Category::getCategoriesList();

        // Товар по id
        $product = Product::getProductById($productId);

        require_once (ROOT . '/views/product/view.php');
        return true;
    }

}