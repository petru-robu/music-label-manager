<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Album.php';
require_once __DIR__ . '/../Models/Artist.php';

class AlbumController extends Controller
{
    private $albumModel;

    public function __construct()
    {
        $this->albumModel = new Album();
    }

    // HELPER METHODS
    private function requireUser(string $message)
    {
        // require logged in user
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo $message;
            return null;
        }
        return $user_id;
    }

    private function requireArtist($user_id, $artist_id, string $message)
    {
        // compare current logged-in artist with the route artist_id
        $artist = Artist::getByUserId($user_id);
        if (!$artist || ($artist_id !== null && $artist->id != (int)$artist_id))
        {
            http_response_code(403);
            echo $message;
            return null;
        }
        return $artist;
    }

    private function requireOwnedAlbum($artist, $album_id, string $message)
    {
        // compare album's artist with the route artist_id   
        $album = $this->albumModel->getAlbumById((int)$album_id);
        if (!$album || $album->artist_id != $artist->id)
        {
            http_response_code(404);
            echo $message;
            return null;
        }
        return $album;
    }

    // CONTROLLER ACTIONS
    public function index()
    {
        // list all albums with artist names
        $albums = $this->albumModel->getAllWithArtistName();
        $this->render('Album/index', ['albums' => $albums]);
    }

    public function indexByArtist($artist_id)
    {
        // list the albums owned by an artist
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist");
        if (!$artist)
            return;

        $albums = $this->albumModel->getByArtistId($artist_id);

        $this->render('Album/indexArtist', [
            'albums' => $albums,
            'artist_id' => $artist_id
        ]);
    }

    public function delete($artist_id, $album_id)
    {
        // delete an album from an user
        $user_id = $this->requireUser("Unauthorized");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist");
        if (!$artist)
            return;

        $album = $this->requireOwnedAlbum($artist, $album_id, "Album not found");
        if (!$album)
            return;

        $deleted = $this->albumModel->deleteAlbum((int)$album_id);

        if ($deleted)
        {
            header("Location: /artist/{$artist->id}/album");
            exit;
        }

        http_response_code(500);
        echo "Failed to delete album.";
    }

    public function update($artist_id, $album_id)
    {
        // update an album
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist.");
        if (!$artist)
            return;

        $title = $_POST['title'] ?? null;
        $release_year = $_POST['release_year'] ?? null;
        $genre = $_POST['genre'] ?? '';

        if (!$title)
        {
            http_response_code(400);
            echo "Bad Request: Title is required.";
            return;
        }

        $album = $this->requireOwnedAlbum($artist, $album_id, "Album not found.");
        if (!$album)
            return;

        $updated = $this->albumModel->updateAlbum(
            (int)$album_id,
            $artist->id,
            $title,
            $release_year ? (int)$release_year : null,
            $genre
        );

        if ($updated)
        {
            header("Location: /artist/{$artist->id}/album");
            exit;
        }

        http_response_code(500);
        echo "Failed to update album.";
    }

    public function edit($artist_id, $album_id)
    {
        // acces the edit form of an album
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist.");
        if (!$artist)
            return;

        $album = $this->requireOwnedAlbum($artist, $album_id, "Album not found.");
        if (!$album)
            return;

        $this->render('Album/edit', [
            'album' => $album,
            'artist_id' => $artist->id
        ]);
    }

    public function view($artist_id, $album_id)
    {
        // return a view of the album
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist");
        if (!$artist)
            return;

        $album = $this->requireOwnedAlbum($artist, $album_id, "Album not found");
        if (!$album)
            return;

        $this->render('Album/view', [
            'album' => $album,
            'artist_id' => $artist->id
        ]);
    }

    public function create()
    {
        // return the album creation form
        $user_id = $this->requireUser("Unauthorized: User not logged in.");
        if (!$user_id)
            return;

        $artist = Artist::getByUserId($user_id);
        if (!$artist)
        {
            http_response_code(404);
            echo "Artist profile not found.";
            return;
        }

        $this->render('Album/create', ['artist_id' => $artist->id]);
    }

    public function store()
    {
        // store a new album in the database
        $user_id = $this->requireUser("Unauthorized: User not logged in.");
        if (!$user_id)
            return;

        $artist = Artist::getByUserId($user_id);
        if (!$artist)
        {
            http_response_code(404);
            echo "Artist profile not found.";
            return;
        }

        $artist_id = $artist->id;
        $title = $_POST['title'] ?? null;
        $release_year = $_POST['release_year'] ?? null;
        $genre = $_POST['genre'] ?? '';

        if (!$artist_id || !$title)
        {
            http_response_code(400);
            echo "Bad Request: Missing required fields.";
            return;
        }

        $album = new Album();
        $stored = $album->createAlbum(
            $artist_id,
            $title,
            $release_year,
            $genre
        );

        if ($stored)
        {
            header("Location: /artist/{$artist_id}/album");
            exit;
        }
        else
        {
            http_response_code(500);
            echo "Failed to update album.";
        }
    }
}
