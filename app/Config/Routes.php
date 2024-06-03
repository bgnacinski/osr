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
    $routes->get("(:any)", "Admin::index/$1");

    $routes->group("user", function($routes){
        $routes->get("edit/(:int)", "Admin::edit_page/$1");
        $routes->post("edit/(:int)", "Admin::edit/$1");

        $routes->get("delete/(:int)", "Admin::delete_page/$1");
        $routes->post("delete/(:int)", "Admin::delete/$1");
    });
});