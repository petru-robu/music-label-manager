<?php

require_once __DIR__ . '/../Database.php';

return new class {
    public function up()
    {
        $pdo = Database::getConnection();

        $songs = [
            // Mick Jagger – Sticky Fingers (album_id = 1)
            ['album_id' => 1, 'title' => 'Brown Sugar', 'duration' => 215],
            ['album_id' => 1, 'title' => 'Wild Horses', 'duration' => 310],
            ['album_id' => 1, 'title' => 'Bitch', 'duration' => 200],
            ['album_id' => 1, 'title' => 'Sister Morphine', 'duration' => 270],
            ['album_id' => 1, 'title' => 'Dead Flowers', 'duration' => 240],

            // Mick Jagger – Let It Bleed (album_id = 2)
            ['album_id' => 2, 'title' => 'Gimme Shelter', 'duration' => 270],
            ['album_id' => 2, 'title' => 'You Can’t Always Get What You Want', 'duration' => 420],
            ['album_id' => 2, 'title' => 'Love in Vain', 'duration' => 260],
            ['album_id' => 2, 'title' => 'Midnight Rambler', 'duration' => 410],
            ['album_id' => 2, 'title' => 'Monkey Man', 'duration' => 240],

            // David Bowie – Ziggy Stardust (album_id = 3)
            ['album_id' => 3, 'title' => 'Starman', 'duration' => 250],
            ['album_id' => 3, 'title' => 'Suffragette City', 'duration' => 220],
            ['album_id' => 3, 'title' => 'Moonage Daydream', 'duration' => 270],
            ['album_id' => 3, 'title' => 'Ziggy Stardust', 'duration' => 185],
            ['album_id' => 3, 'title' => 'Five Years', 'duration' => 270],

            // David Bowie – Heroes (album_id = 4)
            ['album_id' => 4, 'title' => 'Heroes', 'duration' => 390],
            ['album_id' => 4, 'title' => 'Beauty and the Beast', 'duration' => 235],
            ['album_id' => 4, 'title' => 'Joe the Lion', 'duration' => 220],
            ['album_id' => 4, 'title' => 'Sons of the Silent Age', 'duration' => 200],
            ['album_id' => 4, 'title' => 'Blackout', 'duration' => 180],

            // Freddie Mercury – A Night at the Opera (album_id = 5)
            ['album_id' => 5, 'title' => 'Bohemian Rhapsody', 'duration' => 355],
            ['album_id' => 5, 'title' => 'Love of My Life', 'duration' => 220],
            ['album_id' => 5, 'title' => 'You’re My Best Friend', 'duration' => 170],
            ['album_id' => 5, 'title' => '39', 'duration' => 210],
            ['album_id' => 5, 'title' => 'Death on Two Legs', 'duration' => 210],

            // Freddie Mercury – News of the World (album_id = 6)
            ['album_id' => 6, 'title' => 'We Will Rock You', 'duration' => 125],
            ['album_id' => 6, 'title' => 'We Are the Champions', 'duration' => 180],
            ['album_id' => 6, 'title' => 'Sheer Heart Attack', 'duration' => 180],
            ['album_id' => 6, 'title' => 'It’s Late', 'duration' => 320],
            ['album_id' => 6, 'title' => 'Get Down, Make Love', 'duration' => 300],

            // Jimi Hendrix – Are You Experienced (album_id = 7)
            ['album_id' => 7, 'title' => 'Purple Haze', 'duration' => 170],
            ['album_id' => 7, 'title' => 'Hey Joe', 'duration' => 210],
            ['album_id' => 7, 'title' => 'The Wind Cries Mary', 'duration' => 200],
            ['album_id' => 7, 'title' => 'Fire', 'duration' => 180],
            ['album_id' => 7, 'title' => 'Foxy Lady', 'duration' => 220],

            // Jimi Hendrix – Electric Ladyland (album_id = 8)
            ['album_id' => 8, 'title' => 'Voodoo Child (Slight Return)', 'duration' => 315],
            ['album_id' => 8, 'title' => 'All Along the Watchtower', 'duration' => 240],
            ['album_id' => 8, 'title' => 'Crosstown Traffic', 'duration' => 160],
            ['album_id' => 8, 'title' => 'Gypsy Eyes', 'duration' => 210],
            ['album_id' => 8, 'title' => '1983… (A Merman I Should Turn to Be)', 'duration' => 440],

            // Janis Joplin – Pearl (album_id = 9)
            ['album_id' => 9, 'title' => 'Me and Bobby McGee', 'duration' => 270],
            ['album_id' => 9, 'title' => 'Mercedes Benz', 'duration' => 90],
            ['album_id' => 9, 'title' => 'Cry Baby', 'duration' => 280],
            ['album_id' => 9, 'title' => 'A Woman Left Lonely', 'duration' => 230],
            ['album_id' => 9, 'title' => 'Get It While You Can', 'duration' => 240],

            // Janis Joplin – Cheap Thrills (album_id = 10)
            ['album_id' => 10, 'title' => 'Summertime', 'duration' => 280],
            ['album_id' => 10, 'title' => 'Ball and Chain', 'duration' => 480],
            ['album_id' => 10, 'title' => 'Piece of My Heart', 'duration' => 260],
            ['album_id' => 10, 'title' => 'Work Me, Lord', 'duration' => 200],
            ['album_id' => 10, 'title' => 'Catch Me Daddy', 'duration' => 180],

            // Elvis Presley – Elvis Presley (album_id = 11)
            ['album_id' => 11, 'title' => 'Blue Suede Shoes', 'duration' => 120],
            ['album_id' => 11, 'title' => 'I Got a Woman', 'duration' => 150],
            ['album_id' => 11, 'title' => 'I Love You Because', 'duration' => 180],
            ['album_id' => 11, 'title' => 'Just Because', 'duration' => 160],
            ['album_id' => 11, 'title' => 'Tryin’ to Get to You', 'duration' => 210],

            // Elvis Presley – Elvis (album_id = 12)
            ['album_id' => 12, 'title' => 'Love Me Tender', 'duration' => 150],
            ['album_id' => 12, 'title' => 'Any Way You Want Me', 'duration' => 140],
            ['album_id' => 12, 'title' => 'Paralyzed', 'duration' => 130],
            ['album_id' => 12, 'title' => 'Old Shep', 'duration' => 120],
            ['album_id' => 12, 'title' => 'So Glad You’re Mine', 'duration' => 180],

            // John Lennon – Imagine (album_id = 13)
            ['album_id' => 13, 'title' => 'Imagine', 'duration' => 185],
            ['album_id' => 13, 'title' => 'Jealous Guy', 'duration' => 255],
            ['album_id' => 13, 'title' => 'Crippled Inside', 'duration' => 210],
            ['album_id' => 13, 'title' => 'It’s So Hard', 'duration' => 200],
            ['album_id' => 13, 'title' => 'Gimme Some Truth', 'duration' => 200],

            // John Lennon – Plastic Ono Band (album_id = 14)
            ['album_id' => 14, 'title' => 'Mother', 'duration' => 310],
            ['album_id' => 14, 'title' => 'Working Class Hero', 'duration' => 210],
            ['album_id' => 14, 'title' => 'God', 'duration' => 230],
            ['album_id' => 14, 'title' => 'Isolation', 'duration' => 200],
            ['album_id' => 14, 'title' => 'Well Well Well', 'duration' => 250],

            // Paul McCartney – McCartney (album_id = 15)
            ['album_id' => 15, 'title' => 'Maybe I’m Amazed', 'duration' => 230],
            ['album_id' => 15, 'title' => 'Every Night', 'duration' => 160],
            ['album_id' => 15, 'title' => 'The Lovely Linda', 'duration' => 160],
            ['album_id' => 15, 'title' => 'Junk', 'duration' => 150],
            ['album_id' => 15, 'title' => 'That Would Be Something', 'duration' => 140],

            // Paul McCartney – Ram (album_id = 16)
            ['album_id' => 16, 'title' => 'Uncle Albert/Admiral Halsey', 'duration' => 225],
            ['album_id' => 16, 'title' => 'Too Many People', 'duration' => 190],
            ['album_id' => 16, 'title' => 'Eat at Home', 'duration' => 210],
            ['album_id' => 16, 'title' => 'Long Haired Lady', 'duration' => 170],
            ['album_id' => 16, 'title' => '3 Legs', 'duration' => 180],

            // Robert Plant – Led Zeppelin IV (album_id = 17)
            ['album_id' => 17, 'title' => 'Stairway to Heaven', 'duration' => 480],
            ['album_id' => 17, 'title' => 'Black Dog', 'duration' => 290],
            ['album_id' => 17, 'title' => 'Rock and Roll', 'duration' => 220],
            ['album_id' => 17, 'title' => 'When the Levee Breaks', 'duration' => 420],
            ['album_id' => 17, 'title' => 'Going to California', 'duration' => 210],

            // Robert Plant – Houses of the Holy (album_id = 18)
            ['album_id' => 18, 'title' => 'The Ocean', 'duration' => 270],
            ['album_id' => 18, 'title' => 'Over the Hills and Far Away', 'duration' => 260],
            ['album_id' => 18, 'title' => 'Dancing Days', 'duration' => 230],
            ['album_id' => 18, 'title' => 'No Quarter', 'duration' => 420],
            ['album_id' => 18, 'title' => 'The Crunge', 'duration' => 200],

            // Ozzy Osbourne – Blizzard of Ozz (album_id = 19)
            ['album_id' => 19, 'title' => 'Crazy Train', 'duration' => 305],
            ['album_id' => 19, 'title' => 'Mr. Crowley', 'duration' => 330],
            ['album_id' => 19, 'title' => 'Goodbye to Romance', 'duration' => 280],
            ['album_id' => 19, 'title' => 'I Don’t Know', 'duration' => 270],
            ['album_id' => 19, 'title' => 'Dee', 'duration' => 230],

            // Ozzy Osbourne – Diary of a Madman (album_id = 20)
            ['album_id' => 20, 'title' => 'Flying High Again', 'duration' => 260],
            ['album_id' => 20, 'title' => 'Over the Mountain', 'duration' => 280],
            ['album_id' => 20, 'title' => 'You Can’t Kill Rock and Roll', 'duration' => 250],
            ['album_id' => 20, 'title' => 'Diary of a Madman', 'duration' => 320],
            ['album_id' => 20, 'title' => 'Believer', 'duration' => 300],
        ];


        $stmt = $pdo->prepare("
            INSERT INTO songs (album_id, title, duration)
            VALUES (:album_id, :title, :duration)
        ");

        foreach ($songs as $song) {
            $stmt->execute($song);
        }
    }

    public function down()
    {
        $pdo = Database::getConnection();
        $pdo->exec("DELETE FROM songs");
    }
};
