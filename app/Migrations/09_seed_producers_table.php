<?php

require_once __DIR__ . '/../Database.php';

return new class
{
    public function up()
    {
        $pdo = Database::getConnection();

        $producers = [
            [
            'user_id' => 18,
            'studio_name' => 'Rick Rubin Studios',
            'bio' => 'Legendary producer who has worked with Metallica, Slayer, Red Hot Chili Peppers, and countless other iconic rock, metal, and hip-hop artists. Known for minimalistic production style and revitalizing careers across genres.',
            ],
            [
            'user_id' => 19,
            'studio_name' => 'Bob Rock Productions',
            'bio' => 'Renowned for producing rock and metal legends such as Metallica, Mötley Crüe, and Bon Jovi. Famous for his polished, powerful sound and ability to bring out the best in heavy music.',
            ],
            [
            'user_id' => 20,
            'studio_name' => 'Terry Date Productions',
            'bio' => 'Iconic producer known for his work with Pantera, Deftones, and Soundgarden. Recognized for his aggressive yet clear production style in heavy music.',
            ],
            [
            'user_id' => 21,
            'studio_name' => 'Andy Wallace Productions',
            'bio' => 'Veteran producer and mixing engineer for Nirvana, Slayer, and Jeff Buckley. Known for his precise mixing skills that maintain power and clarity in rock and metal tracks.',
            ],
            [
            'user_id' => 22,
            'studio_name' => 'Steve Modest Productions',
            'bio' => 'Experienced producer in hard rock and metal genres, collaborating with both emerging and established bands to craft dynamic and high-impact recordings.',
            ],
        ];

        $stmt = $pdo->prepare("
            INSERT INTO producers (user_id, studio_name, bio)
            VALUES (:user_id, :studio_name, :bio)
        ");

        foreach ($producers as $producer)
            $stmt->execute($producer);
    }

    public function down()
    {
        $pdo = Database::getConnection();
        // optionally undo the seed
        $pdo->exec("DELETE FROM producers WHERE user_id IN (13, 14, 15)");
    }
};
