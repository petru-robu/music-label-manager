<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Artist.php';

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

        switch ($_SESSION['role']) 
        {
            case 1: // admin
                header('Location: /admin/dashboard');
                break;
            case 2: // artist
                header('Location: /artist/dashboard');
                break;
            default: // regular user
                header('Location: /user/dashboard');
                break;
        }
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') 
        {   
            return $this->render('Auth/register');
        }

        else if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $username = $_POST['username'] ?? '';
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = 1;
            
            if ($this->userModel->usernameExists($username))
            {
                echo 'An user with this username already exists in the database!';
                return;
            }

            if ($this->userModel->emailExists($email))
            {
                echo 'An user with this email already exists in the database!';
                return;
            }

            if ($this->userModel->createUser($username, $full_name, $email, $password, $role)) 
            {
                header("Location: /login");
                exit;
            }

            return $this->render('Auth/register', [
                'error' => 'Registration failed!'
            ]);
        }
    }

    public function register_artist()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') 
        {   
            return $this->render('Auth/register_artist');
        }

        else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // User data
            $username = trim($_POST['username'] ?? '');
            $full_name = trim($_POST['full_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $role = 2; // artist role

            // Artist data
            $stage_name = trim($_POST['stage_name'] ?? '');
            $bio = trim($_POST['bio'] ?? '');

            // Validate required fields
            if (!$username || !$full_name || !$email || !$password || !$stage_name) {
                return $this->render('Auth/register_artist', [
                    'error' => 'Please fill in all required fields.'
                ]);
            }

            // Check uniqueness
            if ($this->userModel->usernameExists($username)) {
                return $this->render('Auth/register_artist', [
                    'error' => 'Username already exists!'
                ]);
            }

            if ($this->userModel->emailExists($email)) {
                return $this->render('Auth/register_artist', [
                    'error' => 'Email already exists!'
                ]);
            }

            // 1. Create user
            $user_id = $this->userModel->createUser($username, $full_name, $email, $password, $role);

            if (!$user_id) {
                return $this->render('Auth/register_artist', [
                    'error' => 'Failed to create user account.'
                ]);
            }

            // 2. Create artist linked to user
            $artist_id = Artist::createArtist($user_id, $stage_name, $bio);

            if (!$artist_id) {
                // Rollback user creation
                $this->userModel->deleteUser($user_id);

                return $this->render('Auth/register_artist', [
                    'error' => 'Failed to create artist profile.'
                ]);
            }

            // Success
            header("Location: /login");
            exit;
        }
    }




    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
