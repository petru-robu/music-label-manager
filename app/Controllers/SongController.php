<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Song.php';

class SongController extends Controller
{
    private $songModel;

    public function __construct()
    {
        $this->songModel = new Song;
    }

    public function index(): void
    {
        $songs = $this->songModel->getAll();
        $this->render('Song/index', ['songs' => $songs]);
    }
}
