<?php

require_once __DIR__ . '/../Database.php';

return new class
{
    public function up()
    {
        $pdo = Database::getConnection();

        $artists = [
            [
            'user_id' => 4,
            'stage_name' => 'Metallica',
            'bio' => 'Legendary thrash metal band formed in 1981, known for redefining heavy metal with albums like "Master of Puppets" and "Ride the Lightning". Their influence spans decades, shaping modern metal globally.',
            ],
            [
            'user_id' => 5,
            'stage_name' => 'Iron Maiden',
            'bio' => 'Pioneering British heavy metal band known for their complex compositions, iconic mascot "Eddie", and epic live performances that have defined metal for generations.',
            ],
            [
            'user_id' => 6,
            'stage_name' => 'Slayer',
            'bio' => 'American thrash metal band celebrated for fast tempos, aggressive riffs, and dark, intense lyrics. Their albums like "Reign in Blood" are milestones in extreme metal.',
            ],
            [
            'user_id' => 7,
            'stage_name' => 'Megadeth',
            'bio' => 'Founded by Dave Mustaine, Megadeth is a cornerstone of thrash metal, known for intricate guitar work, socially conscious lyrics, and influential albums such as "Rust in Peace".',
            ],
            [
            'user_id' => 8,
            'stage_name' => 'Pantera',
            'bio' => 'American heavy metal band that revolutionized groove metal in the 1990s. Known for aggressive riffs, powerful vocals by Phil Anselmo, and albums like "Vulgar Display of Power".',
            ],
            [
            'user_id' => 9,
            'stage_name' => 'Black Sabbath',
            'bio' => 'The originators of heavy metal, Black Sabbath combined dark themes, heavy riffs, and groundbreaking music. Their work has influenced countless metal and rock bands worldwide.',
            ],
            [
            'user_id' => 10,
            'stage_name' => 'Ozzy Osbourne',
            'bio' => 'The Prince of Darkness, lead vocalist of Black Sabbath and solo metal icon. Known for his unique voice, theatrical performances, and lasting impact on heavy metal culture.',
            ],
            [
            'user_id' => 11,
            'stage_name' => 'Judas Priest',
            'bio' => 'British heavy metal band known for twin guitar attack, leather-and-studs image, and albums like "Painkiller". Their sound helped define the genre’s identity.',
            ],
            [
            'user_id' => 12,
            'stage_name' => 'Motörhead',
            'bio' => 'Iconic British band led by Lemmy Kilmister, combining rock and metal with a punk attitude. Known for speed, attitude, and timeless tracks like "Ace of Spades".',
            ],
            [
            'user_id' => 13,
            'stage_name' => 'System of a Down',
            'bio' => 'Armenian-American metal band recognized for eclectic style, political lyrics, and energetic performances. Albums like "Toxicity" cemented them as a unique force in alternative metal.',
            ],
            [
            'user_id' => 14,
            'stage_name' => 'Slipknot',
            'bio' => 'American nu-metal band famous for chaotic live shows, masks, and aggressive sound blending metal, hardcore, and industrial elements. Their albums have pushed metal boundaries.',
            ],
            [
            'user_id' => 15,
            'stage_name' => 'Avenged Sevenfold',
            'bio' => 'American heavy metal band blending metalcore and classic metal influences. Known for technical guitar work, melodic vocals, and albums like "City of Evil".',
            ],
            [
            'user_id' => 16,
            'stage_name' => 'Dave Grohl',
            'bio' => 'Multi-talented musician and founder of Foo Fighters, former drummer of Nirvana. Renowned for songwriting, drumming, and significant influence in rock and metal music.',
            ],
            [
            'user_id' => 17,
            'stage_name' => 'Angus Young',
            'bio' => 'Lead guitarist of AC/DC, famous for energetic performances, schoolboy outfit, and legendary riffs on albums like "Back in Black". A central figure in hard rock history.',
            ],
            [
            'user_id' => 18,
            'stage_name' => 'Rick Rubin',
            'bio' => 'Influential record producer in metal and rock, co-founder of Def Jam Records. Known for producing legendary albums for Metallica, Slayer, Red Hot Chili Peppers, and shaping modern music production.',
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