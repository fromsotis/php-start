<?php
return [

    // маршрут для обработки /product/id-товара
    'product/([0-9]+)' => 'product/view/$1', // actionView в ProductController

    'catalog' => 'catalog/index', // actionIndex в CatalogController

    // Пагинация
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
    'cabinet/edit' => 'cabinet/edit', // actionEdit в CabinetController
    'cabinet' => 'cabinet/index', // actionIndex в CabinetController

    // Обратная связь
    'contacts' => 'site/contact', // actionContact в siteController

    // маршрут для обработки localhost без строки запроса
    '' => 'site/index', // actionIndex в SiteController
];