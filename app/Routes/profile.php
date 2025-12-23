<?php

$router->get('/profile/edit', function ()
{
    if (!isset($_SESSION['user_id'], $_SESSION['role']))
    {
        header('Location: /login');
        exit;
    }

    $routes = [
        2 => '/artist/profile/edit',
        3 => '/listener/profile/edit',
        4 => '/producer/profile/edit',
    ];

    $role = $_SESSION['role'];

    header('Location: ' . ($routes[$role] ?? '/login'));
    exit;
}, ['Auth']);

// edit artist profile
$router->get('/artist/profile/edit', 'ArtistController@editProfile', ['Auth', 'Role:2']);
$router->post('/artist/profile/update', 'ArtistController@updateProfile', ['Auth', "Role:2"]);

// edit listener profile
$router->get('/listener/profile/edit', 'ListenerController@editProfile', ['Auth', 'Role:3']);
$router->post('/listener/profile/update', 'ListenerController@updateProfile', ['Auth', 'Role:3']);

// edit producer profile
$router->get('/producer/profile/edit', 'ProducerController@editProfile', ['Auth', 'Role:4']);
$router->post('/producer/profile/update', 'ProducerController@updateProfile', ['Auth', 'Role:4']);