<?php
// album management
$router->get('/artist/:artist_id/album', 'AlbumController@indexByArtist', ['Auth', 'Role:2']); // index albums

$router->get('/artist/:artist_id/album/create', 'AlbumController@create', ['Auth', 'Role:2']); // create form
$router->post('/artist/:artist_id/album/store', 'AlbumController@store', ['Auth', 'Role:2']); // create table as ..

$router->get('/artist/:artist_id/album/:album_id/edit', 'AlbumController@edit', ['Auth', 'Role:2']); // edit form
$router->post('/artist/:artist_id/album/:album_id/update', 'AlbumController@update', ['Auth', 'Role:2']); // update table as ..

$router->get('/artist/:artist_id/album/:album_id/delete', 'AlbumController@delete', ['Auth', 'Role:2']); // delete from

$router->get('/artist/:artist_id/album/:album_id/view', 'AlbumController@view', ['Auth', 'Role:2']); // view route


// song management
$router->get('/artist/:artist_id/album/:album_id/song','SongController@indexByAlbum',['Auth', 'Role:2']); // index songs

$router->get('/artist/:artist_id/album/:album_id/song/create','SongController@create',['Auth', 'Role:2']); // create form
$router->post('/artist/:artist_id/album/:album_id/song/store','SongController@store',['Auth', 'Role:2']); // create table as ..

$router->get('/artist/:artist_id/album/:album_id/song/:song_id/edit','SongController@edit',['Auth', 'Role:2']); // edit form
$router->post('/artist/:artist_id/album/:album_id/song/:song_id/update','SongController@update',['Auth', 'Role:2']); // update form

$router->get('/artist/:artist_id/album/:album_id/song/:song_id/delete','SongController@delete',['Auth', 'Role:2']); // delete from