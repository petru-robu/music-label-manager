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

    public function index($artist_id)
    {
        // returns a view of all albums
        $albums = $this->albumModel->getAll();
        $this->render('Album/index', ['albums' => $albums]);
    }

    public function indexByArtist($artist_id)
    {
        // Ensure user is logged in
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }
        
        // Get the artist for the logged-in user
        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int)$artist_id)
        {
            http_response_code(403);
            echo "Unauthorized artist";
            return;
        }

        // get all albums for this artist
        $albums = $this->albumModel->getByArtistId($artist_id);

        $this->render('Album/indexArtist', [
            'albums' => $albums,
            'artist_id' => $artist_id
        ]);
    }

    public function delete($artist_id, $album_id)
    {
        // delete a specific album
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo "Unauthorized";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int)$artist_id)
        {
            http_response_code(403);
            echo "Unauthorized artist";
            return;
        }

        $album = $this->albumModel->getAlbumById((int)$album_id);

        if (!$album || $album->artist_id != $artist->id)
        {
            http_response_code(404);
            echo "Album not found";
            return;
        }

        $deleted = $this->albumModel->deleteAlbum((int)$album_id);

        if ($deleted)
        {
            // deleted successfully
            header("Location: /artist/{$artist->id}/album");
            exit;
        }

        http_response_code(500);
        echo "Failed to delete album.";
    }

    public function update($artist_id, $album_id)
    {
        // update a specific album
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int)$artist_id)
        {
            http_response_code(403);
            echo "Unauthorized artist.";
            return;
        }

        $title = $_POST['title'] ?? null;
        $release_year = $_POST['release_year'] ?? null;
        $genre = $_POST['genre'] ?? '';

        if (!$title)
        {
            http_response_code(400);
            echo "Bad Request: Title is required.";
            return;
        }

        $album = $this->albumModel->getAlbumById((int)$album_id);

        if (!$album || $album->artist_id != $artist->id)
        {
            http_response_code(404);
            echo "Album not found.";
            return;
        }

        $updated = $this->albumModel->updateAlbum(
            (int)$album_id,
            $artist->id,
            $title,
            $release_year ? (int)$release_year : null,
            $genre
        );

        if ($updated)
        {
            // update successfully
            header("Location: /artist/{$artist->id}/album");
            exit;
        }

        http_response_code(500);
        echo "Failed to update album.";
    }


    public function edit($artist_id, $album_id)
    {
        // returns the view for editing an artist
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int)$artist_id)
        {
            http_response_code(403);
            echo "Unauthorized artist.";
            return;
        }

        $album = $this->albumModel->getAlbumById((int)$album_id);

        if (!$album || $album->artist_id != $artist->id)
        {
            http_response_code(404);
            echo "Album not found.";
            return;
        }

        $this->render('Album/edit', [
            'album' => $album,
            'artist_id' => $artist->id
        ]);
    }

    public function view($artist_id, $album_id)
    {
        // Ensure user is logged in
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }

        // Get the artist for the logged-in user
        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int)$artist_id)
        {
            http_response_code(403);
            echo "Unauthorized artist";
            return;
        }

        // Get the album and check ownership
        $album = $this->albumModel->getAlbumById((int)$album_id);
        if (!$album || $album->artist_id != $artist->id)
        {
            http_response_code(404);
            echo "Album not found";
            return;
        }

        // Render the view
        $this->render('Album/view', [
            'album' => $album,
            'artist_id' => $artist->id
        ]);
    }


    public function create()
    {
        // the create form
        // get the artist id
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo "Unauthorized: User not logged in.";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist)
        {
            http_response_code(404);
            echo "Artist profile not found.";
            return;
        }
        $artist_id = $artist->id;
        $this->render('Album/create', ['artist_id' => $artist_id]);
    }

    public function store()
    {
        // store a new album
        // get the artist id of the current session
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo "Unauthorized: User not logged in.";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist)
        {
            http_response_code(404);
            echo "Artist profile not found.";
            return;
        }

        $artist_id = $artist->id;
        // get data from post request
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
