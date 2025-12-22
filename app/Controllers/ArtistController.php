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

    // helpers
    private function requireUser()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo "Unauthorized.";
            return null;
        }
        return (int)$user_id;
    }

    private function requireArtistOwner($artist_id)
    {
        $user_id = $this->requireUser();
        if (!$user_id)
            return null;

        $artist = $this->artistModel->getArtistById((int)$artist_id);
        if (!$artist || (int)$artist->user_id !== $user_id)
        {
            http_response_code(403);
            echo "Unauthorized artist.";
            return null;
        }

        return $artist;
    }

    private function getRequestId()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            return $_POST['id'] ?? null;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            return $_GET['id'] ?? null;
        }
        return null;
    }

    private function redirectIndex()
    {
        header('Location: /artists');
        exit;
    }

    // actions
    public function index()
    {
        if (!$this->requireUser())
            return;

        $artists = $this->artistModel->getAll();
        $this->render('Artist/index', ['artists' => $artists]);
    }

    public function edit()
    {
        $id = $this->getRequestId();
        if (!$id)
        {
            http_response_code(400);
            echo "Bad Request: Artist ID is required.";
            return;
        }

        if (!$artist = $this->requireArtistOwner($id))
            return;

        $this->render('Artist/edit', ['artist' => $artist]);
    }

    public function update()
    {
        if (!$this->requireUser())
            return;

        $id = $_POST['id'] ?? null;
        $stage_name = $_POST['stage_name'] ?? null;
        $bio = $_POST['bio'] ?? '';

        if (!$id || !$stage_name)
        {
            http_response_code(400);
            echo "Bad Request: Missing required fields.";
            return;
        }

        if (!$artist = $this->requireArtistOwner($id))
            return;

        $updated = $this->artistModel->updateArtist(
            $artist->id,
            $artist->user_id,
            $stage_name,
            $bio
        );

        if ($updated)
        {
            $this->redirectIndex();
        }

        http_response_code(500);
        echo "Failed to update artist.";
    }

    public function delete()
    {
        $id = $this->getRequestId();
        if (!$id)
        {
            http_response_code(400);
            echo "Bad Request: Artist ID is required.";
            return;
        }

        if (!$artist = $this->requireArtistOwner($id))
            return;

        if ($this->artistModel->deleteArtist($artist->id))
        {
            $this->redirectIndex();
        }

        http_response_code(404);
        echo "Artist not found or could not be deleted.";
    }
}
