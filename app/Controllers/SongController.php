<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Song.php';
require_once __DIR__ . '/../Models/Album.php';
require_once __DIR__ . '/../Models/Artist.php';

class SongController extends Controller
{
    private $songModel;
    private $albumModel;

    public function __construct()
    {
        $this->songModel = new Song();
        $this->albumModel = new Album();
    }

    // HELPERS
    private function requireUser(string $message)
    {
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
        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int)$artist_id)
        {
            http_response_code(403);
            echo $message;
            return null;
        }
        return $artist;
    }

    private function requireAlbum($artist, $album_id, string $message)
    {
        $album = $this->albumModel->getAlbumById((int)$album_id);
        if (!$album || $album->artist_id != $artist->id)
        {
            http_response_code(404);
            echo $message;
            return null;
        }
        return $album;
    }

    private function requireSong($album, $song_id, string $message)
    {
        $song = $this->songModel->getSongById((int)$song_id);
        if (!$song || $song->album_id != $album->id)
        {
            http_response_code(404);
            echo $message;
            return null;
        }
        return $song;
    }

    // CONTROLLER ACTIONS
    public function index()
    {
        // Fetch all songs with artist and album year
        $songs = $this->songModel->getAllWithAlbumInfo();
        $this->render('Song/index', ['songs' => $songs]);
    }


    public function indexByAlbum($artist_id, $album_id)
    {
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist.");
        if (!$artist)
            return;

        $album = $this->requireAlbum($artist, $album_id, "Album not found.");
        if (!$album)
            return;

        $songs = $this->songModel->getByAlbumId((int)$album_id);

        $this->render('Song/indexAlbum', [
            'songs' => $songs,
            'artist_id' => $artist_id,
            'album_id' => $album_id
        ]);
    }

    public function create($artist_id, $album_id)
    {
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist.");
        if (!$artist)
            return;

        $album = $this->requireAlbum($artist, $album_id, "Album not found.");
        if (!$album)
            return;

        $this->render('Song/create', [
            'artist_id' => $artist->id,
            'album_id' => $album->id
        ]);
    }

    public function store($artist_id, $album_id)
    {
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist.");
        if (!$artist)
            return;

        $album = $this->requireAlbum($artist, $album_id, "Album not found.");
        if (!$album)
            return;

        $title = $_POST['title'] ?? null;
        $duration = $_POST['duration'] ?? null;

        if (!$title)
        {
            http_response_code(400);
            echo "Bad Request: Title is required.";
            return;
        }

        $stored = $this->songModel->createSong(
            $album->id,
            $title,
            $duration ? (int)$duration : null
        );

        if ($stored)
        {
            header("Location: /artist/{$artist->id}/album/{$album->id}/song");
            exit;
        }

        http_response_code(500);
        echo "Failed to create song.";
    }

    public function edit($artist_id, $album_id, $song_id)
    {
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist.");
        if (!$artist)
            return;

        $album = $this->requireAlbum($artist, $album_id, "Album not found.");
        if (!$album)
            return;

        $song = $this->requireSong($album, $song_id, "Song not found.");
        if (!$song)
            return;

        $this->render('Song/edit', [
            'song' => $song,
            'artist_id' => $artist->id,
            'album_id' => $album->id
        ]);
    }

    public function update($artist_id, $album_id, $song_id)
    {
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist.");
        if (!$artist)
            return;

        $album = $this->requireAlbum($artist, $album_id, "Album not found.");
        if (!$album)
            return;

        $song = $this->requireSong($album, $song_id, "Song not found.");
        if (!$song)
            return;

        $title = $_POST['title'] ?? null;
        $duration = $_POST['duration'] ?? null;

        if (!$title)
        {
            http_response_code(400);
            echo "Bad Request: Title is required.";
            return;
        }

        $updated = $this->songModel->updateSong(
            $song->id,
            $title,
            $duration ? (int)$duration : null
        );

        if ($updated)
        {
            header("Location: /artist/{$artist->id}/album/{$album->id}/song");
            exit;
        }

        http_response_code(500);
        echo "Failed to update song.";
    }

    public function delete($artist_id, $album_id, $song_id)
    {
        $user_id = $this->requireUser("Unauthorized.");
        if (!$user_id)
            return;

        $artist = $this->requireArtist($user_id, $artist_id, "Unauthorized artist.");
        if (!$artist)
            return;

        $album = $this->requireAlbum($artist, $album_id, "Album not found.");
        if (!$album)
            return;

        $song = $this->requireSong($album, $song_id, "Song not found.");
        if (!$song)
            return;

        $deleted = $this->songModel->deleteSong($song->id);

        if ($deleted)
        {
            header("Location: /artist/{$artist->id}/album/{$album->id}/song");
            exit;
        }

        http_response_code(500);
        echo "Failed to delete song.";
    }
}
