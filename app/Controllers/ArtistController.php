<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Artist.php';

class ArtistController extends Controller
{
    private $artistModel;

    public function __construct()
    {
        $this->artistModel = new Artist();
    }

    public function index()
    {
        // returns a view of all artists
        $artists = $this->artistModel->getAll();
        $this->render('Artist/index', ['artists' => $artists]);
    }

    public function delete()
    {
        // deletes an artist
        // check deletion route
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
            $id = $_GET['id'] ?? null;
        else if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $id = $_POST['id'] ?? null;
        else {
            echo 'Invalid request.';
            exit;
        }

        if (!$id) {
            http_response_code(400);
            echo "Bad Request: Artist ID is required.";
            return;
        }

        $id = (int) $id;
        $deleted = $this->artistModel->deleteArtist($id);
        if ($deleted) {
            header('Location: /artists');
            exit;
        } else {
            http_response_code(404);
            echo "Artist not found or could not be deleted.";
        }
    }

    public function update()
    {
        // update an artist
        $id = $_POST['id'] ?? null;
        $user_id = $_POST['user_id'] ?? null;
        $stage_name = $_POST['stage_name'] ?? null;
        $bio = $_POST['bio'] ?? '';

        if (!$id || !$user_id || !$stage_name) {
            http_response_code(400);
            echo "Bad Request: Missing required fields.";
            return;
        }

        $id = (int) $id;
        $user_id = (int) $user_id;

        $artist = $this->artistModel->getArtistById($id);

        if (!$artist) {
            http_response_code(404);
            echo "Artist not found.";
            return;
        }

        $updated = $this->artistModel->updateArtist($id, $user_id, $stage_name, $bio);

        if ($updated) {
            header('Location: /artists');
            exit;
        } else {
            http_response_code(500);
            echo "Failed to update artist.";
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo "Bad Request: Artist ID is required.";
            return;
        }

        $id = (int) $id;
        $artist = $this->artistModel->getArtistById($id);
        if (!$artist) {
            http_response_code(404);
            echo "Artist not found.";
            return;
        }

        $this->render('Artist/edit', ['artist' => $artist]);
    }
}
