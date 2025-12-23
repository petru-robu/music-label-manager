<?php

// Show form to create a production for a specific producer
$router->get('/producer/:producer_id/album/create', 'ProducerAlbumController@createForm', ['Auth', 'Role:4']);
$router->post('/producer/:producer_id/album/store', 'ProducerAlbumController@store', ['Auth', 'Role:4']);

// List all productions for a specific producer
$router->get('/producer/:producer_id/album', 'ProducerAlbumController@index', ['Auth', 'Role:4']);

// Delete a production
$router->get('/producer/:producer_id/album/:id/delete', 'ProducerAlbumController@delete', ['Auth', 'Role:4']);
