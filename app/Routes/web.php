<?php
require_once __DIR__ . "/../Core/Router.php";
$router = new Router();

// include separate route files
require_once __DIR__ . '/admin.php';
require_once __DIR__ . '/artist.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/dashboard.php';
require_once __DIR__ . '/listener.php';
require_once __DIR__ . '/misc.php';
require_once __DIR__ . '/producer.php';
require_once __DIR__ . '/profile.php';
require_once __DIR__ . '/public.php';


$router->dispatch();


