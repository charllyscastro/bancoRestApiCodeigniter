<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// http://bancorest.test/api/
$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes){
    $routes->get('clientes', 'Clientes::index');
});