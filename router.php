<?php
    require_once 'database/config.php';
    require_once 'libs/routerPro.php';
    require_once 'app/controllers/categoria.api.controller.php';
    require_once 'app/controllers/producto.api.controller.php';

    $router = new Router();
    //Rutas para tabla categorias
    #                   endpoint        verbo          controller               método
    $router->addRoute('categorias',     'GET',   'categoriaApiController',  'getCategorias' );
    $router->addRoute('categorias',     'POST',  'categoriaApiController',  'addCategoria' );
    $router->addRoute('categorias/:ID', 'GET',   'categoriaApiController',  'getCategorias' );
    $router->addRoute('categorias/:ID', 'PUT',   'categoriaApiController',  'actualizarCategoria' );
    $router->addRoute('categorias/:ID', 'DELETE','categoriaApiController',  'deleteCategoria');
    
    //Rutas para la tabla productos
    $router->addRoute('productos',     'GET',     'productoApiController',   'getProductos');
    $router->addRoute('productos',     'POST',    'productoApiController',   'addProducto' );
    $router->addRoute('productos/:ID', 'GET',     'productoApiController',   'getProducto');
    $router->addRoute('productos/:ID', 'PUT',     'productoApiController',   'actualizarProducto');
    $router->addRoute('productos/:ID', 'DELETE',  'productoApiController',   'deleteProducto');

    //token
    $router->addRoute('usuario/token',  'GET',     'usuarioApiController',       'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
