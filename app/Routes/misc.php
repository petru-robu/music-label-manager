<?php
// report generation
$router->get('/users/:id/report', 'UserController@generateReport', ['Auth', 'Role:1']);


// contact form
$router->get('/contact', 'ContactController@index');
$router->post('/contact/submit', 'ContactController@submit');