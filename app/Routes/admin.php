<?php
// user management routes (for admins only)
$router->get('/users', 'UserController@index', ['Auth', 'Role:1']);
$router->get('/users/delete', 'UserController@delete', ['Auth', 'Role:1']);
$router->post('/users/update', 'UserController@update', ['Auth', 'Role:1']);
$router->get('/users/edit', 'UserController@edit', ['Auth', 'Role:1']);

// admin analytics
$router->get('/admin/analytics', 'AnalyticsController@index', ['Auth', 'Role:1']);
$router->get('/admin/analytics/purge/:days', 'AnalyticsController@purgeOld', ['Auth', 'Role:1']);