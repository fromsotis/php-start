<?php
return [
    // маршрут для обработки /product/id-товара
    'product/([0-9]+)' => 'product/view/$1', // actionView($1) в ProductController

    // Пагинация в каталоге ($1 - номер старници)
    'catalog/page-([0-9]+)' => 'catalog/index/$1', // actionIndex($1) в CatalogController
    'catalog' => 'catalog/index', // actionIndex в CatalogController

    // Пагинация в выбраной категории ($1-id категории, $2-номер страници)
    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', // actionCategory в CatalogController
    'category/([0-9]+)' => 'catalog/category/$1', // actionCategory в CatalogController

    // Корзина (синхронное)
    'cart/add/([0-9]+)' => 'cart/add/$1', // actionAdd в CartController
    // Корзина (Ajax)
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', // actionAddAjax в CartController

    // Оформление заказа товара из корзины
    'cart/checkout' => 'cart/checkout', // actionCheckout в CartController
    // Удалить товар в корзине по id товара
    'cart/delete/([0-9]+)' => 'cart/delete/$1', // actionDelete в CartController

    // Просмотр товаров в корзине
    'cart' => 'cart/index', // actionIndex в CartController

    // Регистрация, авторизация, выход
    'user/register' => 'user/register', // actionRegister в UserController
    'user/login' => 'user/login', // actionLogin в UserController
    'user/logout' => 'user/logout', // actionLogout в UserController

    // Личный кабинет
    'cabinet' => 'cabinet/index', // actionIndex в CabinetController

    // Управление товарами:
    'admin/product/create' => 'adminProduct/create',    // actionIndex AdminProductController
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1', // actionUpdate($1) AdminProductController
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1', // actionDelete($1) AdminProductController
    'admin/product' => 'adminProduct/index',
    // Управление категориями:
    'admin/category/create' => 'adminCategory/create',
    'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',
    'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
    'admin/category' => 'adminCategory/index', // actionIndex AdminCategoryController
    // Управление заказами:
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',
    'admin/order/view/([0-9]+)' => 'adminOrder/view/$1',
    'admin/order' => 'adminOrder/index',
    // Админпанель:
    'admin' => 'admin/index', // actionIndex AdminController

    // Обратная связь
    'contacts' => 'site/contact', // actionContact в siteController

    // маршрут для обработки localhost без строки запроса
    '' => 'site/index', // actionIndex в SiteController
];