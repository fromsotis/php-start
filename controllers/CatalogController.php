<?php

include_once ROOT . '/models/Category.php';
include_once ROOT . '/models/Product.php';

class CatalogController
{
    public function actionIndex() : bool
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $lastProducts = [];
        $lastProducts = Product::getLatestProduct(9);

        require_once (ROOT . '/views/catalog/index.php');
        return true;
    }

    public function actionCategory(int $categoryId) : bool
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $categoryProducts = [];
        $categoryProducts = Product::getProductListByCategory($categoryId);

        require_once (ROOT . '/views/catalog/category.php');
        return true;
    }
}