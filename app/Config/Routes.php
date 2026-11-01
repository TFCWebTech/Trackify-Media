<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('Home', 'Home::index');
$routes->get('About', 'About::index');
$routes->get('Contact', 'Contact::index');