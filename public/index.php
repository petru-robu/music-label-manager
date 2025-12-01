<?php

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();

try {
    \App\Database::getConnection();
} catch (\PDOException $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    exit($e->getMessage());
}

use App\Controllers\SongController;

$uri = strtok($_SERVER['REQUEST_URI'], '?');

switch ($uri) {
    case '/':
        // Default homepage
        echo '<h1>Welcome to the Music Label App!</h1>';
        echo '<p>To see the list of songs, visit: <a href="/songs">/songs</a></p>';
        break;

    case '/songs':
        // Instantiate the SongController and run its index method
        $controller = new SongController;
        $controller->index();
        break;

    default:
        // Handle 404 Not Found
        http_response_code(404);
        header('Content-Type: text/plain');
        echo '404 Not Found';
        break;
}
