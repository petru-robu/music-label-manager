<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Artist.php';
require_once __DIR__ . '/../Models/Producer.php';
require_once __DIR__ . '/../Services/MailService.php';

class AuthController extends Controller
{
    private $userModel;
    private $mailService;

    public function __construct()
    {
        $this->userModel = new User();
        $this->mailService = new MailService();
    }

    // HELPERS
    private function setError(string $message)
    {
        $_SESSION['error'] = $message;
    }

    private function getError(): ?string
    {
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        return $error;
    }

    private function renderWithError(string $view, array $extra = [])
    {
        $error = $this->getError();
        return $this->render($view, array_merge($extra, ['error' => $error]));
    }

    private function validateCaptcha(string $input): bool
    {
        // validate captcha response
        return !empty($input) && $input === ($_SESSION['captcha'] ?? '');
    }

    private function checkUsernameEmail(string $username, string $email): bool
    {
        // input validation
        if ($this->userModel->usernameExists($username))
        {
            $this->setError('Username already exists!');
            return false;
        }
        if ($this->userModel->emailExists($email))
        {
            $this->setError('Email already exists!');
            return false;
        }
        return true;
    }

    private function createUserAndProfile(
        string $username,
        string $full_name,
        string $email,
        string $password,
        int $role,
        ?callable $profileCreator = null
    ): ?int {
        $user_id = $this->userModel->createUser($username, $full_name, $email, $password, $role);
        if (!$user_id)
        {
            $this->setError('Failed to create user account.');
            return null;
        }

        if ($profileCreator)
        {
            $profile_id = $profileCreator($user_id);
            if (!$profile_id)
            {
                $this->userModel->deleteUser($user_id);
                $this->setError('Failed to create profile.');
                return null;
            }
        }

        // send welcome email safely
        try
        {
            $this->mailService->send($email, 'Welcome', 'Thanks for registering.');
        }
        catch (\Throwable $e)
        {
            if ($profileCreator)
                $profileCreator = null;
            $this->userModel->deleteUser($user_id);
            $this->setError('Registration failed: email service error.');
            return null;
        }

        return $user_id;
    }

    // CONTROLLER ACTIONS
    public function login()
    {
        // login
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            return $this->renderWithError('Auth/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::getByEmail($email);

        if (!$user || !$user->verifyPassword($password))
        {
            $this->setError('Invalid email or password');
            header('Location: /login');
            exit;
        }
        
        // success
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role_id;

        header('Location: /dashboard');
        exit;
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            return $this->renderWithError('Auth/register');
        }

        if (!$this->validateCaptcha($_POST['captcha'] ?? ''))
        {
            $this->setError('Invalid captcha!');
            return $this->renderWithError('Auth/register');
        }

        $username = trim($_POST['username'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = 3; // normal listener

        if (!$this->checkUsernameEmail($username, $email))
        {
            return $this->renderWithError('Auth/register');
        }

        $user_id = $this->createUserAndProfile($username, $full_name, $email, $password, $role);
        if (!$user_id)
            return $this->renderWithError('Auth/register');

        return $this->render('Auth/register', [
            'success' => 'Registration successful! You can now log in. <br> Log in <a href="/login">here</a>.'
        ]);
    }

    public function register_artist()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $success = $_SESSION['success'] ?? '';
            unset($_SESSION['success']);
            return $this->render('Auth/register_artist', [
                'error' => $this->getError(),
                'success' => $success
            ]);
        }

        if (!$this->validateCaptcha($_POST['captcha'] ?? ''))
        {
            $this->setError('Invalid CAPTCHA!');
            return $this->renderWithError('Auth/register_artist');
        }

        $username = trim($_POST['username'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $stage_name = trim($_POST['stage_name'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $role = 2; // artist role

        if (!$username || !$full_name || !$email || !$password || !$stage_name)
        {
            $this->setError('Please fill in all required fields.');
            return $this->renderWithError('Auth/register_artist');
        }

        if (!$this->checkUsernameEmail($username, $email))
        {
            return $this->renderWithError('Auth/register_artist');
        }

        $user_id = $this->createUserAndProfile(
            $username,
            $full_name,
            $email,
            $password,
            $role,
            fn($uid) => Artist::createArtist($uid, $stage_name, $bio)
        );

        if (!$user_id)
            return $this->renderWithError('Auth/register_artist');

        return $this->render('Auth/register', [
            'success' => 'Registration successful! You can now log in.<br /> Log in <a href="/login">here</a>.'
        ]);
    }

    public function register_producer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $success = $_SESSION['success'] ?? '';
            unset($_SESSION['success']);
            return $this->render('Auth/register_producer', [
                'error' => $this->getError(),
                'success' => $success
            ]);
        }

        if (!$this->validateCaptcha($_POST['captcha'] ?? ''))
        {
            $this->setError('Invalid CAPTCHA!');
            return $this->renderWithError('Auth/register_producer');
        }

        $username = trim($_POST['username'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $studio_name = trim($_POST['studio_name'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $role = 4; //producer role

        if (!$username || !$full_name || !$email || !$password || !$studio_name)
        {
            $this->setError('Please fill in all required fields.');
            return $this->renderWithError('Auth/register_producer');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->setError('Please enter a valid email address.');
            return $this->renderWithError('Auth/register_producer');
        }

        if (!$this->checkUsernameEmail($username, $email))
        {
            return $this->renderWithError('Auth/register_producer');
        }

        $user_id = $this->createUserAndProfile(
            $username,
            $full_name,
            $email,
            $password,
            $role,
            fn($uid) => Producer::createProducer($uid, $studio_name, $bio)
        );

        if (!$user_id)
            return $this->renderWithError('Auth/register_producer');

        return $this->render('Auth/register', [
            'success' => 'Registration successful! You can now log in.<br /> Log in <a href="/login">here</a>.'
        ]);
    }
}
