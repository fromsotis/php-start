<?php
return [
    // маршрут для обработки /product/id-товара
    'product/([0-9]+)' => 'product/view/$1', // actionView в ProductController

    'catalog' => 'catalog/index', // actionIndex в CatalogController

    'category/([0-9]+)' => 'catalog/category/$1', // actionCategory в CatalogController

    // маршрут для обработки localhost без строки запроса
    '' => 'site/index', // actionIndex в SiteController
];