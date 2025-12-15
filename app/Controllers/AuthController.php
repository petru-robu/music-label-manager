<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Artist.php';
require_once __DIR__ . '/../Services/MailService.php';

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

        // Validate CAPTCHA
        $captcha = $_POST['captcha'] ?? '';
        if (empty($captcha) || $captcha !== ($_SESSION['captcha'] ?? ''))
        {
            $this->setError('Invalid captcha!');
            return $this->render('Auth/register', ['error' => $this->getError()]);
        }

        $username = trim($_POST['username'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = 1;

        if ($this->userModel->usernameExists($username))
        {
            $this->setError('Username already exists!');
            return $this->render('Auth/register', ['error' => $this->getError()]);
        }

        if ($this->userModel->emailExists($email))
        {
            $this->setError('Email already exists!');
            return $this->render('Auth/register', ['error' => $this->getError()]);
        }

        if (!$this->userModel->createUser($username, $full_name, $email, $password, $role))
        {
            $this->setError('Registration failed!');
            return $this->render('Auth/register', ['error' => $this->getError()]);
        }

        // Send welcome email
        $mailService = new MailService();
        $mailService->send($email, 'Welcome', 'Thanks for registering.');

        // Render same page with success message
        return $this->render('Auth/register', [
            'success' => 'Registration successful! You can now log in. <br> Log in <a href="/login">here</a>.'
        ]);
    }

    public function register_artist()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $error = $this->getError();
            $success = $_SESSION['success'] ?? '';
            unset($_SESSION['success']);

            return $this->render('Auth/register_artist', [
                'error' => $error,
                'success' => $success
            ]);
        }

        // Validate CAPTCHA
        $captcha = $_POST['captcha'] ?? '';
        if (empty($captcha) || $captcha !== ($_SESSION['captcha'] ?? ''))
        {
            $this->setError('Invalid CAPTCHA!');
            return $this->render('Auth/register_artist', ['error' => $this->getError()]);
        }

        // Get form inputs
        $username = trim($_POST['username'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = 2;

        $stage_name = trim($_POST['stage_name'] ?? '');
        $bio = trim($_POST['bio'] ?? '');

        // Validate required fields
        if (!$username || !$full_name || !$email || !$password || !$stage_name)
        {
            $this->setError('Please fill in all required fields.');
            return $this->render('Auth/register_artist', ['error' => $this->getError()]);
        }

        if ($this->userModel->usernameExists($username))
        {
            $this->setError('Username already exists!');
            return $this->render('Auth/register_artist', ['error' => $this->getError()]);
        }

        if ($this->userModel->emailExists($email))
        {
            $this->setError('Email already exists!');
            return $this->render('Auth/register_artist', ['error' => $this->getError()]);
        }

        // Create user
        $user_id = $this->userModel->createUser($username, $full_name, $email, $password, $role);
        if (!$user_id)
        {
            $this->setError('Failed to create user account.');
            return $this->render('Auth/register_artist', ['error' => $this->getError()]);
        }

        // Create artist
        $artist_id = Artist::createArtist($user_id, $stage_name, $bio);
        if (!$artist_id)
        {
            $this->userModel->deleteUser($user_id);
            $this->setError('Failed to create artist profile.');
            return $this->render('Auth/register_artist', ['error' => $this->getError()]);
        }

        // Send welcome email
        $mailService = new MailService();
        $mailService->send($email, 'Welcome', 'Thanks for registering.');

        // Render same page with success message
        return $this->render('Auth/register', [
            'success' => 'Registration successful! You can now log in.<br /> Log in <a href="/login">here</a>.'
        ]);
    }


    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
