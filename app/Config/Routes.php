<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ["filter" => "webauth"]);

$routes->get("login", "Home::login_page");
$routes->post("login", "Home::login");

$routes->group("account", ["filter" => "webauth"], function ($routes) {
    $routes->get("/","Home::account_page");
    $routes->post("/","Home::account_update");

    $routes->post("logout", "Home::logout");

    $routes->get("change-password", "Home::change_password_page");
    $routes->post("change-password", "Home::change_password");
});

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

$routes->group("panel", ["filter" => "webauth"], function($routes){
    $routes->get("/", "Home::panel");

    $routes->group("bills", function($routes){
        $routes->get("/", "Bills::index");
        $routes->get("(:num)", "Bills::index/$1");

        $routes->get("view/(:num)", "Bills::view/$1");

        $routes->get("add", "Bills::add_page");
        $routes->post("add", "Bills::add");

        $routes->get("edit/(:num)", "Bills::edit_page/$1");
        $routes->post("edit/(:num)", "Bills::edit/$1");

        $routes->get("delete/(:num)", "Bills::delete_page/$1");
        $routes->post("delete/(:num)", "Bills::delete/$1");
    });

    $routes->group("clients", ["filter" => "webauth"], function($routes){
        $routes->get("/", "Client::index");
        $routes->get("(:num)", "Client::index/$1");

        $routes->get("add", "Client::add_page");
        $routes->post("add", "Client::add");
    });

    $routes->group("jobs", ["filter" => "webauth"], function($routes){
        $routes->get("/", "Jobs::index");
    });
});