<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class ListenerController extends Controller
{
    // Render the edit form for the listener
    public function editProfile()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId)
        {
            http_response_code(403);
            echo "Unauthorized access.";
            return;
        }

        $user = User::getUserById($userId);

        if (!$user)
        {
            http_response_code(404);
            echo "Profile not found.";
            return;
        }

        $this->render('Listener/editProfile', [
            'user' => $user
        ]);
    }

    // Handle form submission to update listener profile
    public function updateProfile()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId)
        {
            http_response_code(403);
            echo "Unauthorized access.";
            return;
        }

        $user = User::getUserById($userId);

        if (!$user)
        {
            http_response_code(404);
            echo "Profile not found.";
            return;
        }

        // Get user inputs
        $username = trim($_POST['username'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validate required fields
        if ($name === '' || $email === '')
        {
            http_response_code(400);
            echo "Name and email are required.";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            http_response_code(400);
            echo "Invalid email address.";
            return;
        }

        // Only update password if provided
        if ($password)
            User::updateUser($userId, $user->role_id, $username, $name, $email, $password);
        else
            User::updateUser($userId, $user->role_id, $username, $name, $email);

        // Redirect to listener dashboard after update
        header('Location: /dashboard');
        exit;
    }
}
