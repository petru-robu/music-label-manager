<?php

namespace App\Controllers;

use App\Models\Song;

class SongController
{
    private $songModel;

    public function __construct()
    {
        $this->songModel = new Song;
    }

    public function index(): void
    {
        $songs = $this->songModel->getAll();
        header('Content-Type: application/json');

        echo json_encode([
            'status' => 'success',
            'count' => count($songs),
            'data' => $songs,
        ]);
    }
}
