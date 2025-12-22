<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Producer.php';

class ProducerController extends Controller
{
    private $producerModel;

    public function __construct()
    {
        $this->producerModel = new Producer();
    }

    public function index()
    {
        // returns a view of all producers
        $producers = $this->producerModel->getAll();
        $this->render('Producer/index', ['producers' => $producers]);
    }

    public function delete()
    {
        // deletes a producer
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
            $id = $_GET['id'] ?? null;
        else if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $id = $_POST['id'] ?? null;
        else
        {
            echo 'Invalid request.';
            exit;
        }

        if (!$id)
        {
            http_response_code(400);
            echo "Bad Request: Producer ID is required.";
            return;
        }

        $id = (int)$id;
        $deleted = $this->producerModel->deleteProducer($id);

        if ($deleted)
        {
            header('Location: /producers');
            exit;
        }
        else
        {
            http_response_code(404);
            echo "Producer not found or could not be deleted.";
        }
    }

    public function update()
    {
        // update a producer
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

        $producer = $this->producerModel->getProducerById($id);

        if (!$producer)
        {
            http_response_code(404);
            echo "Producer not found.";
            return;
        }

        $updated = $this->producerModel->updateProducer($id, $user_id, $studio_name, $bio);

        if ($updated)
        {
            header('Location: /producers');
            exit;
        }
        else
        {
            http_response_code(500);
            echo "Failed to update producer.";
        }
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

        $id = (int)$id;
        $producer = $this->producerModel->getProducerById($id);

        if (!$producer)
        {
            http_response_code(404);
            echo "Producer not found.";
            return;
        }

        $this->render('Producer/edit', ['producer' => $producer]);
    }
}