<?php
// start the session once here
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

// load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

//load analytics tracker
require_once __DIR__ . '/../app/Core/Analytics.php';
AnalyticsTracker::track();

// load routes
require __DIR__ . '/../app/Routes/web.php';
