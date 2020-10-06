<?php

//include_once ROOT . '/models/Category.php';
//include_once ROOT . '/models/Product.php';
//include_once ROOT . '/components/Pagination.php';

class CatalogController
{
    public function actionIndex() : bool
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $lastProducts = [];
        $lastProducts = Product::getLatestProduct(6);

        require_once (ROOT . '/views/catalog/index.php');
        return true;
    }

    public function actionCategory(int $categoryId, int $page = 1) : bool
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $categoryProducts = [];
        $categoryProducts = Product::getProductListByCategory($categoryId, $page);

        $total = Product::getTotalProductsInCategory($categoryId);
        // Создаем обьект Pagination
        // $total - общее кол-во товаров конкретной категории
        // $page - номер страници
        // Product::SHOW_BY_DEFAULT - кол-во товаров на странице
        // 'page-' - ключ в нашем url (мы так решили в route.php: 'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2')
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');
        require_once (ROOT . '/views/catalog/category.php');
        return true;
    }
}