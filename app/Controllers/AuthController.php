<?php

require_once __DIR__ . '/Controller.php';

class AuthController extends Controller
{
    private $userModel;

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function login(string $email, string $password)
    {
        $user = User::getByEmail($email);

        if (!$user || !$user->verifyPassword($password)) 
        {
            echo "Invalid email or password";
            return;
        }

        // Login successful
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        header('Location: /dashboard');
        exit;
    }


    public function register($username, $full_name, $email, $password, $role = 1)
    {
        if($this->userModel->createUser($username, $full_name, $email, $password, $role))
        {
            header("Location: /login");
            exit;
        }
        else
        {
            return "Registration failed!";
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
