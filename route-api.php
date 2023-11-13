<?php
    
require_once 'libs/Router.php';
require_once 'app/controllers/ApiProductsController.php';




//creamos router

$router = new Router();


//definimos tabla de ruteo.

$router->addRoute('products', 'GET', 'ApiProductsController', 'getProducts');
$router->addRoute('products', 'POST', 'ApiProductsController', 'createProduct');
$router->addRoute('products/:ID', 'DELETE', 'ApiProductsController', 'deleteProduct');
$router->addRoute('products/:ID', 'GET', 'ApiProductsController', 'getProduct');
$router->addRoute('products/:ID', 'PUT', 'ApiProductsController', 'updateProduct');


$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
