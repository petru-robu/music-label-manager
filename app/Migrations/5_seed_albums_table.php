<?php

require_once __DIR__ . '/../Database.php';

return new class {
    public function up()
    {
        $pdo = Database::getConnection();

        $albums = [
            // Mick Jagger
            [
                'artist_id' => 1,
                'title' => 'Sticky Fingers',
                'release_year' => 1971,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 1,
                'title' => 'Let It Bleed',
                'release_year' => 1969,
                'genre' => 'Rock'
            ],

            // David Bowie
            [
                'artist_id' => 2,
                'title' => 'The Rise and Fall of Ziggy Stardust',
                'release_year' => 1972,
                'genre' => 'Glam Rock'
            ],
            [
                'artist_id' => 2,
                'title' => 'Heroes',
                'release_year' => 1977,
                'genre' => 'Rock'
            ],

            // Freddie Mercury
            [
                'artist_id' => 3,
                'title' => 'A Night at the Opera',
                'release_year' => 1975,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 3,
                'title' => 'News of the World',
                'release_year' => 1977,
                'genre' => 'Rock'
            ],

            // Jimi Hendrix
            [
                'artist_id' => 4,
                'title' => 'Are You Experienced',
                'release_year' => 1967,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 4,
                'title' => 'Electric Ladyland',
                'release_year' => 1968,
                'genre' => 'Rock'
            ],

            // Janis Joplin
            [
                'artist_id' => 5,
                'title' => 'Pearl',
                'release_year' => 1971,
                'genre' => 'Blues Rock'
            ],
            [
                'artist_id' => 5,
                'title' => 'Cheap Thrills',
                'release_year' => 1968,
                'genre' => 'Psychedelic Rock'
            ],

            // Elvis Presley
            [
                'artist_id' => 6,
                'title' => 'Elvis Presley',
                'release_year' => 1956,
                'genre' => 'Rock and Roll'
            ],
            [
                'artist_id' => 6,
                'title' => 'Elvis',
                'release_year' => 1956,
                'genre' => 'Rock and Roll'
            ],

            // John Lennon
            [
                'artist_id' => 7,
                'title' => 'Imagine',
                'release_year' => 1971,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 7,
                'title' => 'John Lennon/Plastic Ono Band',
                'release_year' => 1970,
                'genre' => 'Rock'
            ],

            // Paul McCartney
            [
                'artist_id' => 8,
                'title' => 'McCartney',
                'release_year' => 1970,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 8,
                'title' => 'Ram',
                'release_year' => 1971,
                'genre' => 'Rock'
            ],

            // Robert Plant
            [
                'artist_id' => 9,
                'title' => 'Led Zeppelin IV',
                'release_year' => 1971,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 9,
                'title' => 'Houses of the Holy',
                'release_year' => 1973,
                'genre' => 'Rock'
            ],

            // Ozzy Osbourne
            [
                'artist_id' => 10,
                'title' => 'Blizzard of Ozz',
                'release_year' => 1980,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 10,
                'title' => 'Diary of a Madman',
                'release_year' => 1981,
                'genre' => 'Heavy Metal'
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
