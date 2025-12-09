<?php
session_start();

require_once __DIR__.'/../app/Controllers/SongController.php';
require_once __DIR__.'/../app/Controllers/AuthController.php';
require_once __DIR__.'/../app/Models/User.php';
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();
$uri = strtok($_SERVER['REQUEST_URI'], '?');

// default layout functions
function renderHeader($title = 'Music Label App') 
{
    // Check if user is logged in
    $isLoggedIn = isset($_SESSION['user_id']);
    $username = $_SESSION['username'] ?? '';

    echo 
        '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>' . htmlspecialchars($title) . '</title>
            <link rel="stylesheet" href="/style.css">
        </head>
        <body>
            <nav class="navbar">
                <a href="/">Home</a>';

    if ($isLoggedIn) 
    {
        echo '<a href="/dashboard">Dashboard</a>
              <form method="POST" action="/logout" class="logout-form">
                  <button type="submit">Logout</button>
              </form>';
    } 
    else 
    {
        echo '<a href="/login">Login</a>';
    }
    echo '</nav>
          <div class="container">';
}


function renderFooter() 
{
    echo 
        '</div> </body> </html>';
}

switch ($uri) {
    case '/':
        renderHeader('Home');
        echo '<h1>Welcome to the Music Label App!</h1>';
        echo '<p>To see the list of songs, visit: <a href="/songs">Songs</a></p>';
        renderFooter();
        break;

    case '/songs':
        $controller = new SongController;
        renderHeader('Home');
        $controller->index();
        renderFooter();
        break;

    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($email && $password) 
            {
                $userModel = new User();
                $controller = new AuthController($userModel);
                $controller->login($email, $password);
            } 
            else 
            {
                renderHeader('Login');
                echo '<p>Email and password are required.</p>';
                require '../app/Views/Auth/login.php';
                renderFooter();
            }
        } 
        else 
        {
            renderHeader('Login');
            require '../app/Views/Auth/login.php';
            renderFooter();
        }
        break;

    case '/logout':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_destroy();
            header('Location: /login');
            exit;
        }
        break;

    case '/register':
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $full_name = $_POST['full_name'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($full_name && $username && $email && $password) 
            {
                $userModel = new User();
                $controller = new AuthController($userModel);
                $controller->register($username, $full_name, $email, $password); 
            }
        }
        else
        {
            if (isset($_SESSION['user_id'])) 
            {
                header('Location: /dashboard');
                exit;
            }
            renderHeader('Register');
            require '../app/Views/Auth/register.php';
            renderFooter();
        }
        break;

    case '/dashboard':
        if (!isset($_SESSION['user_id'])) 
        {
            header('Location: /login');
            exit;
        }

        renderHeader('Dashboard');
        require '../app/Views/Dashboard.php';
        renderFooter();
        break;

    default:
        http_response_code(404);
        renderHeader('404 Not Found');
        echo '<h1>404 Not Found</h1>';
        echo '<p>The page you requested could not be found.</p>';
        renderFooter();
        break;

}
