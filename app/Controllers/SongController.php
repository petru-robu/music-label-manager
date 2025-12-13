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
        $this->songModel  = new Song();
        $this->albumModel = new Album();
    }

    public function indexByAlbum($artist_id, $album_id)
    {
        $songs = $this->songModel->getByAlbumId((int) $album_id);

        $this->render('Song/indexAlbum', [
            'songs'     => $songs,
            'artist_id'=> $artist_id,
            'album_id' => $album_id
        ]);
    }

    public function create($artist_id, $album_id)
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int) $artist_id) {
            http_response_code(403);
            echo "Unauthorized artist.";
            return;
        }

        $album = $this->albumModel->getAlbumById((int) $album_id);
        if (!$album || $album->artist_id != $artist->id) {
            http_response_code(404);
            echo "Album not found.";
            return;
        }

        $this->render('Song/create', [
            'artist_id' => $artist->id,
            'album_id'  => $album->id
        ]);
    }

    public function store($artist_id, $album_id)
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int) $artist_id) {
            http_response_code(403);
            echo "Unauthorized artist.";
            return;
        }

        $album = $this->albumModel->getAlbumById((int) $album_id);
        if (!$album || $album->artist_id != $artist->id) {
            http_response_code(404);
            echo "Album not found.";
            return;
        }

        $title    = $_POST['title'] ?? null;
        $duration = $_POST['duration'] ?? null;

        if (!$title) {
            http_response_code(400);
            echo "Bad Request: Title is required.";
            return;
        }

        $stored = $this->songModel->createSong(
            $album->id,
            $title,
            $duration ? (int) $duration : null
        );

        if ($stored) {
            header("Location: /artist/{$artist->id}/album/{$album->id}/song");
            exit;
        }

        http_response_code(500);
        echo "Failed to create song.";
    }

    public function edit($artist_id, $album_id, $song_id)
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int) $artist_id) {
            http_response_code(403);
            echo "Unauthorized artist.";
            return;
        }

        $album = $this->albumModel->getAlbumById((int) $album_id);
        if (!$album || $album->artist_id != $artist->id) {
            http_response_code(404);
            echo "Album not found.";
            return;
        }

        $song = $this->songModel->getSongById((int) $song_id);
        if (!$song || $song->album_id != $album->id) {
            http_response_code(404);
            echo "Song not found.";
            return;
        }

        $this->render('Song/edit', [
            'song'      => $song,
            'artist_id'=> $artist->id,
            'album_id' => $album->id
        ]);
    }

    public function update($artist_id, $album_id, $song_id)
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int) $artist_id) {
            http_response_code(403);
            echo "Unauthorized artist.";
            return;
        }

        $album = $this->albumModel->getAlbumById((int) $album_id);
        if (!$album || $album->artist_id != $artist->id) {
            http_response_code(404);
            echo "Album not found.";
            return;
        }

        $song = $this->songModel->getSongById((int) $song_id);
        if (!$song || $song->album_id != $album->id) {
            http_response_code(404);
            echo "Song not found.";
            return;
        }

        $title    = $_POST['title'] ?? null;
        $duration = $_POST['duration'] ?? null;

        if (!$title) {
            http_response_code(400);
            echo "Bad Request: Title is required.";
            return;
        }

        $updated = $this->songModel->updateSong(
            $song->id,
            $title,
            $duration ? (int) $duration : null
        );

        if ($updated) {
            header("Location: /artist/{$artist->id}/album/{$album->id}/song");
            exit;
        }

        http_response_code(500);
        echo "Failed to update song.";
    }

    public function delete($artist_id, $album_id, $song_id)
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }

        $artist = Artist::getByUserId($user_id);
        if (!$artist || $artist->id != (int) $artist_id) {
            http_response_code(403);
            echo "Unauthorized artist.";
            return;
        }

        $album = $this->albumModel->getAlbumById((int) $album_id);
        if (!$album || $album->artist_id != $artist->id) {
            http_response_code(404);
            echo "Album not found.";
            return;
        }

        $song = $this->songModel->getSongById((int) $song_id);
        if (!$song || $song->album_id != $album->id) {
            http_response_code(404);
            echo "Song not found.";
            return;
        }

        $deleted = $this->songModel->deleteSong($song->id);

        if ($deleted) {
            header("Location: /artist/{$artist->id}/album/{$album->id}/song");
            exit;
        }

        http_response_code(500);
        echo "Failed to delete song.";
    }
}
