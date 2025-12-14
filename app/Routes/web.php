<?php
require_once __DIR__ . "/../Core/Router.php";
$router = new Router();

// public routes (seen by all)
$router->get('/', ['view' => 'Home']);
$router->get('/artists', 'ArtistController@index');
$router->get('/albums', 'AlbumController@index');
$router->get('/songs', 'SongController@index');

// auth routes
$router->match(['GET', 'POST'], '/login', 'AuthController@login');
$router->match(['GET', 'POST'], '/register', 'AuthController@register');
$router->match(['GET', 'POST'], '/register_artist', 'AuthController@register_artist');
$router->post('/logout', 'AuthController@logout');

// dashboard (for logged in users)
$router->get('/user/dashboard', ['view' => 'Dashboard/listener'], ['Auth', 'Role:3']);
$router->get('/artist/dashboard', ['view' => 'Dashboard/artist'], ['Auth', 'Role:2']);
$router->get('/admin/dashboard', ['view' => 'Dashboard/admin'], ['Auth', 'Role:1']);
$router->get('/dashboard', function () {
    // redirects to the right route for the logged in user or to login otherwise
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
    $role = $_SESSION['role'];
    $routes = [1 => '/admin/dashboard', 2 => '/artist/dashboard', 3 => '/user/dashboard'];
    header('Location: ' . ($routes[$role] ?? '/login'));
    exit;
}, ['Auth']);

// user management routes (for admins only)
$router->get('/users', 'UserController@index', ['Auth', 'Role:1']);
$router->get('/users/delete', 'UserController@delete', ['Auth', 'Role:1']);
$router->post('/users/update', 'UserController@update', ['Auth', 'Role:1']);
$router->get('/users/edit', 'UserController@edit', ['Auth', 'Role:1']);

// admin analytics
$router->get('/admin/analytics', 'AnalyticsController@index', ['Auth', 'Role:1']);
$router->get('/admin/analytics/purge/:days', 'AnalyticsController@purgeOld', ['Auth', 'Role:1']);

// album management routes for artists only
$router->get('/artist/:artist_id/album', 'AlbumController@indexByArtist', ['Auth', 'Role:2']);

$router->get('/artist/:artist_id/album/create', 'AlbumController@create', ['Auth', 'Role:2']);
$router->post('/artist/:artist_id/album/store', 'AlbumController@store', ['Auth', 'Role:2']);

$router->get('/artist/:artist_id/album/:album_id/edit', 'AlbumController@edit', ['Auth', 'Role:2']);
$router->post('/artist/:artist_id/album/:album_id/update', 'AlbumController@update', ['Auth', 'Role:2']);

$router->get('/artist/:artist_id/album/:album_id/delete', 'AlbumController@delete', ['Auth', 'Role:2']);

// song management routes for artists only
$router->get(
    '/artist/:artist_id/album/:album_id/song',
    'SongController@indexByAlbum',
    ['Auth', 'Role:2']
);

$router->get(
    '/artist/:artist_id/album/:album_id/song/create',
    'SongController@create',
    ['Auth', 'Role:2']
);

$router->post(
    '/artist/:artist_id/album/:album_id/song/store',
    'SongController@store',
    ['Auth', 'Role:2']
);

$router->get(
    '/artist/:artist_id/album/:album_id/song/:song_id/edit',
    'SongController@edit',
    ['Auth', 'Role:2']
);

$router->post(
    '/artist/:artist_id/album/:album_id/song/:song_id/update',
    'SongController@update',
    ['Auth', 'Role:2']
);

$router->get(
    '/artist/:artist_id/album/:album_id/song/:song_id/delete',
    'SongController@delete',
    ['Auth', 'Role:2']
);

$router->dispatch();
