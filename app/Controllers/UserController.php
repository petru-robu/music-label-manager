<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function index()
    {
        // returns a view of all the users
        $users = $this->userModel->getAll();
        $this->render('User/index', ['users' => $users]);
    }

    public function delete()
    {
        // Get id from POST first, fallback to GET
        if ($_SERVER['REQUEST_METHOD'] === 'GET') 
            $id = $_GET['id'];
        else if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $id = $_POST['id'];
        else 
        {
            echo 'Invalid request.';
            exit;
        }

        if (!$id) 
        {
            http_response_code(400);
            echo "Bad Request: User ID is required.";
            return;
        }
        $id = (int) $id;

        // check to not delete oneself
        $currentUserId = $_SESSION['user_id'];
        if ($id === $currentUserId) 
        {
            echo 'Cannot delete yourself. Nice try.';
            exit;
        }

        $deleted = $this->userModel->deleteUser($id);

        if ($deleted) 
        {
            // redirect to users list after deletion
            header('Location: /users');
            exit;
        } 
        else 
        {
            http_response_code(404);
            echo "User not found or could not be deleted.";
        }
    }

    public function update()
    {
        // update an user
        $id = $_POST['id'] ?? null;
        $role_id = $_POST['role_id'] ?? null;
        $username = $_POST['username'] ?? null;
        $email = $_POST['email'] ?? null;
        $full_name = $_POST['full_name'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$id || !$role_id || !$username || !$email || !$full_name) 
        {
            http_response_code(400);
            echo "Bad Request: Missing required fields.";
            return;
        }
        $id = (int) $id;
        $role_id = (int) $role_id;

        // check for not changing role
        $currentUserId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($id);

        if (!$user) 
        {
            http_response_code(404);
            echo "User not found.";
            return;
        }
        // Block only if user tries to change his own role
        if ($id === $currentUserId && $role_id !== $user->role_id) 
        {
            echo "You cannot change your own role. Nice try.";
            return;
        }

        $updated = $this->userModel->updateUser($id, $role_id, $username, $full_name, $email, $password);

        if ($updated) 
        {
            header('Location: /users');
            exit;
        } 
        else 
        {
            http_response_code(500);
            echo "Failed to update user.";
        }
    }

    public function edit()
    {
        // Get user ID from query parameter
        $id = $_GET['id'] ?? null;

        if (!$id) 
        {
            http_response_code(400);
            echo "Bad Request: User ID is required.";
            return;
        }

        $id = (int) $id;

        // Fetch user from database
        $user = $this->userModel->getUserById($id);

        if (!$user) 
        {
            http_response_code(404);
            echo "User not found.";
            return;
        }

        // render the edit form view, passing the user
        $this->render('User/edit', ['user' => $user]);
    }
}   