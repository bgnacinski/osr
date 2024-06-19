<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ["filter" => "webauth"]);

$routes->get("login", "Home::login_page");
$routes->post("login", "Home::login");

$routes->group('admin', ["filter" => "admin"], function($routes){
    $routes->get("/", "Admin::index");
    $routes->get("(:num)", "Admin::index/$1");

    $routes->group("user", function($routes){
        $routes->get("add", "Admin::add_page");
        $routes->post("add", "Admin::add");

        $routes->get("edit/(:num)", "Admin::edit_page/$1");
        $routes->post("edit/(:num)", "Admin::edit/$1");

        $routes->get("delete/(:num)", "Admin::delete_page/$1");
        $routes->post("delete/(:num)", "Admin::delete/$1");

        $routes->get("restore/(:num)", "Admin::restore_page/$1");
        $routes->post("restore/(:num)", "Admin::restore/$1");
    });
});