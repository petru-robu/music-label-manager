<?php

require_once __DIR__ . '/../Database.php';

return new class {
    public function up()
    {
        $pdo = Database::getConnection();

        $artists = [
            [
                'user_id' => 3,
                'stage_name' => 'Mick Jagger',
                'bio' => 'Lead singer of The Rolling Stones, legendary rock icon.',
            ],
            [
                'user_id' => 4,
                'stage_name' => 'David Bowie',
                'bio' => 'Innovative musician and cultural icon known for Ziggy Stardust.',
            ],
            [
                'user_id' => 5,
                'stage_name' => 'Freddie Mercury',
                'bio' => 'Lead vocalist of Queen, known for powerful voice and stage presence.',
            ],
            [
                'user_id' => 6,
                'stage_name' => 'Jimi Hendrix',
                'bio' => 'Guitar legend who revolutionized rock music with his innovative style.',
            ],
            [
                'user_id' => 7,
                'stage_name' => 'Janis Joplin',
                'bio' => 'Iconic blues-rock singer known for her raw, powerful performances.',
            ],
            [
                'user_id' => 8,
                'stage_name' => 'Elvis Presley',
                'bio' => 'The King of Rock and Roll, a global musical phenomenon.',
            ],
            [
                'user_id' => 9,
                'stage_name' => 'John Lennon',
                'bio' => 'Co-founder of The Beatles, influential singer and songwriter.',
            ],
            [
                'user_id' => 10,
                'stage_name' => 'Paul McCartney',
                'bio' => 'Multi-instrumentalist and songwriter, co-founder of The Beatles.',
            ],
            [
                'user_id' => 11,
                'stage_name' => 'Robert Plant',
                'bio' => 'Lead singer of Led Zeppelin, known for his powerful vocal style.',
            ],
            [
                'user_id' => 12,
                'stage_name' => 'Ozzy Osbourne',
                'bio' => 'Lead vocalist of Black Sabbath and solo heavy metal legend.',
            ],
        ];

        $stmt = $pdo->prepare("
            INSERT INTO artists (user_id, stage_name, bio)
            VALUES (:user_id, :stage_name, :bio)
        ");

        foreach ($artists as $artist)
            $stmt->execute($artist);
    }


    public function down()
    {
        $pdo = Database::getConnection();
        // undo the seed
    }

};