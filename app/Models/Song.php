<?php

require_once __DIR__.'/Model.php';

class Song extends Model
{ 
    public function getAll(): array
    {
        try {
            $pdo = Database::getConnection();

            return [
                ['id' => 1, 'title' => 'Stairway to Heaven', 'artist' => 'Led Zeppelin', 'year' => 1971],
                ['id' => 2, 'title' => 'Bohemian Rhapsody', 'artist' => 'Queen', 'year' => 1975],
                ['id' => 3, 'title' => 'Hotel California', 'artist' => 'The Eagles', 'year' => 1976],
            ];

        } catch (\PDOException $e) {
            return ['error' => 'Database operation failed: '.$e->getMessage()];
        }
    }
}
