<?php
require_once __DIR__ . "/../Core/Router.php";
$router = new Router();

// public routes (seen by all)
$router->get('/', ['view' => 'Home']);
$router->get('/songs', 'SongController@index');

// auth routes
$router->match(['GET', 'POST'], '/login', 'AuthController@login');
$router->match(['GET','POST'], '/register', 'AuthController@register');
$router->post('/logout', 'AuthController@logout');

// dashboard (for logged in users)
$router->get('/dashboard', ['view' => 'Dashboard'], ['Auth']);

// user management routes (for admins only)
$router->get('/users', 'UserController@index', ['Auth', 'Role:1']);
$router->post('/users/delete', 'UserController@delete', ['Auth', 'Role:1']);
$router->post('/users/update', 'UserController@update', ['Auth', 'Role:1']);
$router->get('/users/edit', 'UserController@edit', ['Auth', 'Role:1']);

$router->dispatch();