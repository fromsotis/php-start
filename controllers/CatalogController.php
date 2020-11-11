<?php


class CatalogController
{
    /**
     * Action главной страници каталога товаров, с постраничной пагинацией
     * @param int $page : номер страници, если не указан то по умолчению page-1
     * @return bool
     */
    public function actionIndex(int $page = 1) : bool
    {
        // Список категорий для меню
        $categories = Category::getCategoriesList();

        // Список товаров в кол-ве указанном в Product::SHOW_BY_DEFAULT
        $latestProducts = Product::getLatestProduct($page);

        $total = Product::getTotalProducts();
        // Создаем обьект Pagination
        // $total - кол-во всех товаров конкретной категории
        // $page - номер страници
        // Product::SHOW_BY_DEFAULT - кол-во товаров на странице
        // 'page-' - ключ в нашем url (так определено в route.php: 'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2')
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once (ROOT . '/views/catalog/index.php');

        return true;
    }

    /**
     * Action для страницы конкретной категории товаров, с постраничной пагинацией
     * @param int $categoryId
     * @param int $page : номер страници, если не указан то по умолчению page-1
     * @return bool
     */
    public function actionCategory(int $categoryId, int $page = 1) : bool
    {
        // Список категорий для меню
        $categories = Category::getCategoriesList();

        // Список товаров конкретной категории
        $categoryProducts = Product::getProductListByCategory($categoryId, $page);

        // Общее кол-во товаров в категории
        $total = Product::getTotalProductsInCategory($categoryId);
        // Создаем обьект Pagination
        // $total - общее кол-во товаров конкретной категории
        // $page - номер страници
        // Product::SHOW_BY_DEFAULT - кол-во товаров на странице
        // 'page-' - ключ в нашем url (так определено в route.php: 'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2')
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once (ROOT . '/views/catalog/category.php');

        return true;
    }
}