<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/ProducerAlbum.php';
require_once __DIR__ . '/../Models/Artist.php';
require_once __DIR__ . '/../Models/Producer.php';
require_once __DIR__ . '/../Models/Album.php';

class ProducerAlbumController extends Controller
{
    public function createForm($producer_id)
    {
        $producer_id = (int)$producer_id;
        // Optionally check if the producer exists
        $producer = Producer::getProducerById($producer_id);
        if (!$producer)
        {
            http_response_code(404);
            echo "Producer not found.";
            return;
        }

        $artists = Artist::getAll();
        $albumsByArtist = [];
        foreach ($artists as $artist)
        {
            $albumsByArtist[$artist['id']] = Album::getByArtistId($artist['id']);
        }

        $this->render('ProducerAlbum/create', [
            'producer' => $producer,
            'artists' => $artists,
            'albumsByArtist' => $albumsByArtist
        ]);
    }

    public function store($producer_id)
    {
        $producer_id = (int)$producer_id;

        $artist_id = (int)($_POST['artist_id'] ?? 0);
        $album_id = (int)($_POST['album_id'] ?? 0);


        if (!$artist_id || !$album_id)
        {
            http_response_code(400);
            echo "Artist and Album are required.";
            return;
        }

        // Optionally validate the producer exists
        $producer = Producer::getProducerById($producer_id);
        if (!$producer)
        {
            http_response_code(404);
            echo "Producer not found.";
            return;
        }
        ProducerAlbum::create($producer_id, $artist_id, $album_id);

        header('Location: /producer/' . $producer_id . '/album');
        exit;
    }

    public function index($producer_id)
    {
        $producer_id = (int)$producer_id;
        $producer = Producer::getProducerById($producer_id);
        if (!$producer)
        {
            http_response_code(404);
            echo "Producer not found.";
            return;
        }

        $productions = ProducerAlbum::getAllByProducerWithNames($producer_id);

        $this->render('ProducerAlbum/index', [
            'producer' => $producer,
            'productions' => $productions
        ]);
    }

    public function delete($producer_id, $id)
    {
        $producer_id = (int)$producer_id;
        $id = (int)$id;

        // Verify producer exists
        $producer = Producer::getProducerById($producer_id);
        if (!$producer)
        {
            http_response_code(404);
            echo "Producer not found.";
            return;
        }

        $deleted = ProducerAlbum::delete($id);

        if ($deleted)
        {
            header('Location: /producer/' . $producer_id . '/album');
            exit;
        }

        http_response_code(404);
        echo "Production not found or could not be deleted.";
    }
}
