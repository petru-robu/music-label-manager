<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') 
        {
            return $this->render('Auth/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::getByEmail($email);

        if (!$user || !$user->verifyPassword($password)) 
            return $this->render('Auth/login', ['error' => 'Invalid email or password']);

        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role_id;

        header("Location: /dashboard");
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') 
        {   
            return $this->render('Auth/register');
        }

        $username = $_POST['username'] ?? '';
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = 1;

        if ($this->userModel->createUser($username, $full_name, $email, $password, $role)) 
        {
            header("Location: /login");
            exit;
        }

        return $this->render('Auth/register', [
            'error' => 'Registration failed!'
        ]);
    }


    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
