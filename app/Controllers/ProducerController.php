<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Producer.php';
require_once __DIR__ . '/../Models/User.php';

class ProducerController extends Controller
{
    private $producerModel;

    public function __construct()
    {
        $this->producerModel = new Producer();
    }

    // HELPERS
    private function getProducerOrFail(int $id)
    {
        $producer = $this->producerModel->getProducerById($id);
        if (!$producer)
        {
            http_response_code(404);
            echo "Producer not found.";
            exit;
        }
        return $producer;
    }

    private function requirePost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            http_response_code(405);
            echo "Method not allowed.";
            exit;
        }
    }

    // CONTROLLER ACTIONS
    public function index()
    {
        $producers = $this->producerModel->getAll();
        $this->render('Producer/index', ['producers' => $producers]);
    }

    public function delete()
    {
        $id = $_REQUEST['id'] ?? null;
        if (!$id)
        {
            http_response_code(400);
            echo "Bad Request: Producer ID is required.";
            return;
        }

        $deleted = $this->producerModel->deleteProducer((int)$id);

        if ($deleted)
        {
            header('Location: /producers');
            exit;
        }

        http_response_code(404);
        echo "Producer not found or could not be deleted.";
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id)
        {
            http_response_code(400);
            echo "Bad Request: Producer ID is required.";
            return;
        }

        $producer = $this->getProducerOrFail((int)$id);
        $this->render('Producer/edit', ['producer' => $producer]);
    }

    public function update()
    {
        $this->requirePost();

        $id = $_POST['id'] ?? null;
        $user_id = $_POST['user_id'] ?? null;
        $studio_name = $_POST['studio_name'] ?? null;
        $bio = $_POST['bio'] ?? '';

        if (!$id || !$user_id || !$studio_name)
        {
            http_response_code(400);
            echo "Bad Request: Missing required fields.";
            return;
        }

        $id = (int)$id;
        $user_id = (int)$user_id;
        $producer = $this->getProducerOrFail($id);

        $updated = $this->producerModel->updateProducer($id, $user_id, $studio_name, $bio);

        if ($updated)
        {
            header('Location: /producers');
            exit;
        }

        http_response_code(500);
        echo "Failed to update producer.";
    }

    public function editProfile()
    {
        // render the edit form
        $userId = $_SESSION['user_id'];
        $user = User::getUserById($userId);
        $producer = Producer::getByUserId($userId);

        if (!$producer || !$user)
        {
            http_response_code(404);
            echo "Profile not found.";
            return;
        }

        $this->render('Producer/editProfile', [
            'producer' => $producer,
            'user' => $user
        ]);
    }

    public function updateProfile()
    {
        $userId = $_SESSION['user_id'];
        $producer = Producer::getByUserId($userId);
        $user = User::getUserById($userId);

        if (!$producer || !$user)
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
        $studio_name = trim($_POST['studio_name'] ?? '');
        $bio = trim($_POST['bio'] ?? '');

        // Validate required fields
        if ($name === '' || $email === '' || $studio_name === '')
        {
            http_response_code(400);
            echo "Name, email, and studio name are required.";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            http_response_code(400);
            echo "Invalid email address.";
            return;
        }

        // update user
        if ($password)
            User::updateUser($user->id, $user->role_id, $username, $name, $email, $password);
        else
            User::updateUser($user->id, $user->role_id, $username, $name, $email);

        // update producer
        Producer::updateProducer($producer->id, $user->id, $studio_name, $bio);

        header('Location: /producer/dashboard');
        exit;
    }
}
