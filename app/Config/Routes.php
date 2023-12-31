<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/auth/login', 'Auth::login');

// http://bancorest.test/api/
$routes->group('api', ['namespace' => 'App\Controllers\API'], function ($routes) {
    $routes->get('clientes', 'Clientes::index');
    $routes->post('clientes/create', 'Clientes::create');
    $routes->get('clientes/edit/(:num)', 'Clientes::edit/$1');
    $routes->put('clientes/update/(:num)', 'Clientes::update/$1');
    $routes->delete('clientes/delete/(:num)', 'Clientes::delete/$1');

    $routes->get('cuentas', 'Cuentas::index');
    $routes->post('cuentas/create', 'Cuentas::create');
    $routes->get('cuentas/edit/(:num)', 'Cuentas::index/$1');
    $routes->put('cuentas/update/(:num)', 'Cuentas::update/$1');
    $routes->delete('cuentas/delete/(:num)', 'Cuentas::delete/$1');

    $routes->get('tipostransaccion', 'TiposTransaccion::index');
    $routes->post('tipostransaccion/create', 'TiposTransaccion::create');


    $routes->get('transaccion', 'Transacciones::index');
    $routes->post('transaccion/create', 'Transacciones::create');
    $routes->get('transaccion/cliente/(:num)', 'Transacciones::getTransaccionesByCliente/$1');


    $routes->get('roles', 'Roles::index');
    $routes->post('roles/create', 'Roles::create');
    $routes->get('roles/edit/(:num)', 'Roles::edit/$1');
    $routes->put('roles/update/(:num)', 'Roles::update/$1');
    $routes->delete('roles/delete/(:num)', 'Roles::delete/$1');

    $routes->get('usuarios', 'Usuarios::index');
    $routes->post('usuarios/create', 'Usuarios::create');
    $routes->get('usuarios/edit/(:num)', 'Usuarios::edit/$1');
    $routes->put('usuarios/update/(:num)', 'Usuarios::update/$1');
    $routes->delete('usuarios/delete/(:num)', 'Usuarios::delete/$1');
});
