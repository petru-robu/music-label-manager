<?php

require_once __DIR__ . '/../Database.php';

return new class 
{
    public function up()
    {
        $pdo = Database::getConnection();

        $albums = [
            [
                'artist_id' => 1, //Jimmy Hendrix
                'title' => 'Are You Experienced',
                'release_year' => 1967,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 1,
                'title' => 'Electric Ladyland',
                'release_year' => 1968,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 2, //assuming Michael Jackson
                'title' => 'Thriller',
                'release_year' => 1982,
                'genre' => 'Pop'
            ],
            [
                'artist_id' => 2,
                'title' => 'Bad',
                'release_year' => 1987,
                'genre' => 'Pop'
            ],
        ];

        $stmt = $pdo->prepare("
            INSERT INTO albums (artist_id, title, release_year, genre)
            VALUES (:artist_id, :title, :release_year, :genre)
        ");

        foreach ($albums as $album)
            $stmt->execute($album);
    }

    public function down()
    {
        $pdo = Database::getConnection();
        $pdo->exec("DELETE FROM albums");
    }
};
