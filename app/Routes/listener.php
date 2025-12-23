<?php

$router->get('/artists', 'ArtistController@index', ['Auth', 'Role:3']);
$router->get('/albums', 'AlbumController@index', ['Auth', 'Role:3']);
$router->get('/songs','SongController@index', ['Auth', 'Role:3']);