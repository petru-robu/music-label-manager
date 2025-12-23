<?php

// auth routes
$router->match(['GET', 'POST'], '/login', 'AuthController@login');
$router->match(['GET', 'POST'], '/register', 'AuthController@register');
$router->match(['GET', 'POST'], '/register_artist', 'AuthController@register_artist');
$router->match(['GET', 'POST'], '/register_producer', 'AuthController@register_producer');
$router->post('/logout', 'AuthController@logout');