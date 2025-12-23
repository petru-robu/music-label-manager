<?php
// dashboard (for logged in users)
$router->get('/user/dashboard', ['view' => 'Dashboard/listener'], ['Auth', 'Role:3']);
$router->get('/artist/dashboard', ['view' => 'Dashboard/artist'], ['Auth', 'Role:2']);
$router->get('/admin/dashboard', ['view' => 'Dashboard/admin'], ['Auth', 'Role:1']);
$router->get('/producer/dashboard', ['view' => 'Dashboard/producer'], ['Auth', 'Role:4']);
$router->get('/dashboard', function ()
{
    // redirects to the right route for the logged in user or to login otherwise
    if (!isset($_SESSION['user_id']))
    {
        header('Location: /login');
        exit;
    }

    $role = $_SESSION['role'];
    $routes = [
        1 => '/admin/dashboard',
        2 => '/artist/dashboard',
        3 => '/user/dashboard',
        4 => '/producer/dashboard'
    ];

    header('Location: ' . ($routes[$role] ?? '/login'));
    exit;
}, ['Auth']);