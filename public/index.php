<?php
// start the session once here
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

// load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

// load routes
require __DIR__ . '/../app/Routes/web.php';
