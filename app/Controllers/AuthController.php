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
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    private function setError($message)
    {
        $_SESSION['error'] = $message;
    }

    private function getError()
    {
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        return $error;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $error = $this->getError();
            return $this->render('Auth/login', ['error' => $error]);
        }

        // POST request
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $captcha = $_POST['captcha'] ?? '';

        if (empty($captcha) || $captcha !== ($_SESSION['captcha'] ?? ''))
        {
            $this->setError('Invalid CAPTCHA!');
            header('Location: /login');
            exit;
        }

        $user = User::getByEmail($email);

        if (!$user || !$user->verifyPassword($password))
        {
            $this->setError('Invalid email or password');
            header('Location: /login');
            exit;
        }

        // Login success
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role_id;

        header('Location: /dashboard');
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $error = $this->getError();
            return $this->render('Auth/register', ['error' => $error]);
        }

        $captcha = $_POST['captcha'] ?? '';
        if (empty($captcha) || $captcha !== ($_SESSION['captcha'] ?? ''))
        {
            $this->setError('Invalid captcha!');
            header('Location: /register');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = 1;

        if ($this->userModel->usernameExists($username))
        {
            $this->setError('Username already exists!');
            header('Location: /register');
            exit;
        }

        if ($this->userModel->emailExists($email))
        {
            $this->setError('Email already exists!');
            header('Location: /register');
            exit;
        }

        if (!$this->userModel->createUser($username, $full_name, $email, $password, $role))
        {
            $this->setError('Registration failed!');
            header('Location: /register');
            exit;
        }

        header('Location: /login');
        exit;
    }

    public function register_artist()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $error = $this->getError();
            return $this->render('Auth/register_artist', ['error' => $error]);
        }

        $captcha = $_POST['captcha'] ?? '';
        if (empty($captcha) || $captcha !== ($_SESSION['captcha'] ?? ''))
        {
            $this->setError('Invalid CAPTCHA!');
            header('Location: /register_artist');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = 2;

        $stage_name = trim($_POST['stage_name'] ?? '');
        $bio = trim($_POST['bio'] ?? '');

        if (!$username || !$full_name || !$email || !$password || !$stage_name)
        {
            $this->setError('Please fill in all required fields.');
            header('Location: /register_artist');
            exit;
        }

        if ($this->userModel->usernameExists($username))
        {
            $this->setError('Username already exists!');
            header('Location: /register_artist');
            exit;
        }

        if ($this->userModel->emailExists($email))
        {
            $this->setError('Email already exists!');
            header('Location: /register_artist');
            exit;
        }

        // Create user
        $user_id = $this->userModel->createUser($username, $full_name, $email, $password, $role);
        if (!$user_id)
        {
            $this->setError('Failed to create user account.');
            header('Location: /register_artist');
            exit;
        }

        // Create artist
        $artist_id = Artist::createArtist($user_id, $stage_name, $bio);
        if (!$artist_id)
        {
            $this->userModel->deleteUser($user_id);
            $this->setError('Failed to create artist profile.');
            header('Location: /register_artist');
            exit;
        }

        header('Location: /login');
        exit;
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
