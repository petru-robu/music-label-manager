<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Album.php';

class AlbumController extends Controller
{
    private $albumModel;

    public function __construct()
    {
        $this->albumModel = new Album();
    }

    public function index()
    {
        // returns a view of all albums
        $albums = $this->albumModel->getAll();
        $this->render('Album/index', ['albums' => $albums]);
    }

    public function indexByArtist($artist_id = null)
    {
        // if artist ID is not passed, try to get it from logged-in user
        if (!$artist_id) {
            $user_id = $_SESSION['user_id'] ?? null;
            if (!$user_id) {
                http_response_code(403);
                echo "Unauthorized: User not logged in.";
                return;
            }

            $artist = Artist::getByUserId($user_id);
            if (!$artist) {
                http_response_code(404);
                echo "Artist profile not found.";
                return;
            }

            $artist_id = $artist->id;
        }
        // get all albums for this artist
        $albums = $this->albumModel->getByArtistId($artist_id);

        $this->render('Album/indexArtist', [
            'albums' => $albums,
            'artist_id' => $artist_id
        ]);
    }

    public function delete()
    {
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
            echo "Bad Request: Album ID is required.";
            return;
        }

        $id = (int) $id;

        $deleted = $this->albumModel->deleteAlbum($id);

        if ($deleted) {
            header('Location: /albums');
            exit;
        } else {
            http_response_code(404);
            echo "Album not found or could not be deleted.";
        }
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $artist_id = $_POST['artist_id'] ?? null;
        $title = $_POST['title'] ?? null;
        $release_year = $_POST['release_year'] ?? null;
        $genre = $_POST['genre'] ?? '';

        if (!$id || !$artist_id || !$title) {
            http_response_code(400);
            echo "Bad Request: Missing required fields.";
            return;
        }

        $id = (int) $id;
        $artist_id = (int) $artist_id;
        $release_year = $release_year !== null ? (int) $release_year : null;

        $album = $this->albumModel->getAlbumById($id);

        if (!$album) {
            http_response_code(404);
            echo "Album not found.";
            return;
        }

        $updated = $this->albumModel->updateAlbum($id, $artist_id, $title, $release_year, $genre);

        if ($updated) {
            header('Location: /albums');
            exit;
        } else {
            http_response_code(500);
            echo "Failed to update album.";
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo "Bad Request: Album ID is required.";
            return;
        }

        $id = (int) $id;

        $album = $this->albumModel->getAlbumById($id);

        if (!$album) {
            http_response_code(404);
            echo "Album not found.";
            return;
        }

        $this->render('Album/edit', ['album' => $album]);
    }
}
