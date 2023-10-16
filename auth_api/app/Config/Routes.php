<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('token', 'Auth::token');

$routes->post('register', 'Auth::register');


