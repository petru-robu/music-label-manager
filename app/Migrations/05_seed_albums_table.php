<?php

require_once __DIR__ . '/../Database.php';

return new class
{
    public function up()
    {
        $pdo = Database::getConnection();

        $albums = [
        // Metallica
        [
        'artist_id' => 1,
        'title' => 'Master of Puppets',
        'release_year' => 1986,
        'genre' => 'Thrash Metal'
        ],
        [
        'artist_id' => 1,
        'title' => 'Ride the Lightning',
        'release_year' => 1984,
        'genre' => 'Thrash Metal'
        ],
        [
        'artist_id' => 1,
        'title' => '...And Justice for All',
        'release_year' => 1988,
        'genre' => 'Thrash Metal'
        ],

        // Iron Maiden
        [
        'artist_id' => 2,
        'title' => 'The Number of the Beast',
        'release_year' => 1982,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 2,
        'title' => 'Powerslave',
        'release_year' => 1984,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 2,
        'title' => 'Piece of Mind',
        'release_year' => 1983,
        'genre' => 'Heavy Metal'
        ],

        // Slayer
        [
        'artist_id' => 3,
        'title' => 'Reign in Blood',
        'release_year' => 1986,
        'genre' => 'Thrash Metal'
        ],
        [
        'artist_id' => 3,
        'title' => 'South of Heaven',
        'release_year' => 1988,
        'genre' => 'Thrash Metal'
        ],
        [
        'artist_id' => 3,
        'title' => 'Seasons in the Abyss',
        'release_year' => 1990,
        'genre' => 'Thrash Metal'
        ],

        // Megadeth
        [
        'artist_id' => 4,
        'title' => 'Rust in Peace',
        'release_year' => 1990,
        'genre' => 'Thrash Metal'
        ],
        [
        'artist_id' => 4,
        'title' => 'Peace Sells... But Who\'s Buying?',
        'release_year' => 1986,
        'genre' => 'Thrash Metal'
        ],
        [
        'artist_id' => 4,
        'title' => 'Countdown to Extinction',
        'release_year' => 1992,
        'genre' => 'Thrash Metal'
        ],

        // Pantera
        [
        'artist_id' => 5,
        'title' => 'Vulgar Display of Power',
        'release_year' => 1992,
        'genre' => 'Groove Metal'
        ],
        [
        'artist_id' => 5,
        'title' => 'Far Beyond Driven',
        'release_year' => 1994,
        'genre' => 'Groove Metal'
        ],
        [
        'artist_id' => 5,
        'title' => 'Cowboys from Hell',
        'release_year' => 1990,
        'genre' => 'Groove Metal'
        ],

        // Black Sabbath
        [
        'artist_id' => 6,
        'title' => 'Paranoid',
        'release_year' => 1970,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 6,
        'title' => 'Black Sabbath',
        'release_year' => 1970,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 6,
        'title' => 'Sabbath Bloody Sabbath',
        'release_year' => 1973,
        'genre' => 'Heavy Metal'
        ],

        // Ozzy Osbourne
        [
        'artist_id' => 7,
        'title' => 'Blizzard of Ozz',
        'release_year' => 1980,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 7,
        'title' => 'Diary of a Madman',
        'release_year' => 1981,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 7,
        'title' => 'Bark at the Moon',
        'release_year' => 1983,
        'genre' => 'Heavy Metal'
        ],

        // Judas Priest
        [
        'artist_id' => 8,
        'title' => 'British Steel',
        'release_year' => 1980,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 8,
        'title' => 'Painkiller',
        'release_year' => 1990,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 8,
        'title' => 'Screaming for Vengeance',
        'release_year' => 1982,
        'genre' => 'Heavy Metal'
        ],

        // Motörhead
        [
        'artist_id' => 9,
        'title' => 'Ace of Spades',
        'release_year' => 1980,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 9,
        'title' => 'Overkill',
        'release_year' => 1979,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 9,
        'title' => 'Bomber',
        'release_year' => 1979,
        'genre' => 'Heavy Metal'
        ],

        // System of a Down
        [
        'artist_id' => 10,
        'title' => 'Toxicity',
        'release_year' => 2001,
        'genre' => 'Alternative Metal'
        ],
        [
        'artist_id' => 10,
        'title' => 'Mezmerize',
        'release_year' => 2005,
        'genre' => 'Alternative Metal'
        ],
        [
        'artist_id' => 10,
        'title' => 'Hypnotize',
        'release_year' => 2005,
        'genre' => 'Alternative Metal'
        ],

        // Slipknot
        [
        'artist_id' => 11,
        'title' => 'Slipknot',
        'release_year' => 1999,
        'genre' => 'Nu Metal'
        ],
        [
        'artist_id' => 11,
        'title' => 'Iowa',
        'release_year' => 2001,
        'genre' => 'Nu Metal'
        ],
        [
        'artist_id' => 11,
        'title' => 'Vol. 3: (The Subliminal Verses)',
        'release_year' => 2004,
        'genre' => 'Nu Metal'
        ],

        // Avenged Sevenfold
        [
        'artist_id' => 12,
        'title' => 'City of Evil',
        'release_year' => 2005,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 12,
        'title' => 'Avenged Sevenfold',
        'release_year' => 2007,
        'genre' => 'Heavy Metal'
        ],
        [
        'artist_id' => 12,
        'title' => 'Nightmare',
        'release_year' => 2010,
        'genre' => 'Heavy Metal'
        ],

        // Dave Grohl
        [
        'artist_id' => 13,
        'title' => 'Foo Fighters',
        'release_year' => 1995,
        'genre' => 'Rock'
        ],
        [
        'artist_id' => 13,
        'title' => 'The Colour and the Shape',
        'release_year' => 1997,
        'genre' => 'Rock'
        ],
        [
        'artist_id' => 13,
        'title' => 'Wasting Light',
        'release_year' => 2011,
        'genre' => 'Rock'
        ],

        // Angus Young (AC/DC)
        [
        'artist_id' => 14,
        'title' => 'Back in Black',
        'release_year' => 1980,
        'genre' => 'Hard Rock'
        ],
        [
        'artist_id' => 14,
        'title' => 'Highway to Hell',
        'release_year' => 1979,
        'genre' => 'Hard Rock'
        ],
        [
        'artist_id' => 14,
        'title' => 'For Those About to Rock We Salute You',
        'release_year' => 1981,
        'genre' => 'Hard Rock'
        ],
        ];
        $albums = [
            // Metallica
            [
                'artist_id' => 1,
                'title' => 'Master of Puppets',
                'release_year' => 1986,
                'genre' => 'Thrash Metal'
            ],
            [
                'artist_id' => 1,
                'title' => 'Ride the Lightning',
                'release_year' => 1984,
                'genre' => 'Thrash Metal'
            ],
            [
                'artist_id' => 1,
                'title' => '...And Justice for All',
                'release_year' => 1988,
                'genre' => 'Thrash Metal'
            ],

            // Iron Maiden
            [
                'artist_id' => 2,
                'title' => 'The Number of the Beast',
                'release_year' => 1982,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 2,
                'title' => 'Powerslave',
                'release_year' => 1984,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 2,
                'title' => 'Piece of Mind',
                'release_year' => 1983,
                'genre' => 'Heavy Metal'
            ],

            // Slayer
            [
                'artist_id' => 3,
                'title' => 'Reign in Blood',
                'release_year' => 1986,
                'genre' => 'Thrash Metal'
            ],
            [
                'artist_id' => 3,
                'title' => 'South of Heaven',
                'release_year' => 1988,
                'genre' => 'Thrash Metal'
            ],
            [
                'artist_id' => 3,
                'title' => 'Seasons in the Abyss',
                'release_year' => 1990,
                'genre' => 'Thrash Metal'
            ],

            // Megadeth
            [
                'artist_id' => 4,
                'title' => 'Rust in Peace',
                'release_year' => 1990,
                'genre' => 'Thrash Metal'
            ],
            [
                'artist_id' => 4,
                'title' => 'Peace Sells... But Who\'s Buying?',
                'release_year' => 1986,
                'genre' => 'Thrash Metal'
            ],
            [
                'artist_id' => 4,
                'title' => 'Countdown to Extinction',
                'release_year' => 1992,
                'genre' => 'Thrash Metal'
            ],

            // Pantera
            [
                'artist_id' => 5,
                'title' => 'Vulgar Display of Power',
                'release_year' => 1992,
                'genre' => 'Groove Metal'
            ],
            [
                'artist_id' => 5,
                'title' => 'Far Beyond Driven',
                'release_year' => 1994,
                'genre' => 'Groove Metal'
            ],
            [
                'artist_id' => 5,
                'title' => 'Cowboys from Hell',
                'release_year' => 1990,
                'genre' => 'Groove Metal'
            ],

            // Black Sabbath
            [
                'artist_id' => 6,
                'title' => 'Paranoid',
                'release_year' => 1970,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 6,
                'title' => 'Black Sabbath',
                'release_year' => 1970,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 6,
                'title' => 'Sabbath Bloody Sabbath',
                'release_year' => 1973,
                'genre' => 'Heavy Metal'
            ],

            // Ozzy Osbourne
            [
                'artist_id' => 7,
                'title' => 'Blizzard of Ozz',
                'release_year' => 1980,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 7,
                'title' => 'Diary of a Madman',
                'release_year' => 1981,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 7,
                'title' => 'Bark at the Moon',
                'release_year' => 1983,
                'genre' => 'Heavy Metal'
            ],

            // Judas Priest
            [
                'artist_id' => 8,
                'title' => 'British Steel',
                'release_year' => 1980,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 8,
                'title' => 'Painkiller',
                'release_year' => 1990,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 8,
                'title' => 'Screaming for Vengeance',
                'release_year' => 1982,
                'genre' => 'Heavy Metal'
            ],

            // Motörhead
            [
                'artist_id' => 9,
                'title' => 'Ace of Spades',
                'release_year' => 1980,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 9,
                'title' => 'Overkill',
                'release_year' => 1979,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 9,
                'title' => 'Bomber',
                'release_year' => 1979,
                'genre' => 'Heavy Metal'
            ],

            // System of a Down
            [
                'artist_id' => 10,
                'title' => 'Toxicity',
                'release_year' => 2001,
                'genre' => 'Alternative Metal'
            ],
            [
                'artist_id' => 10,
                'title' => 'Mezmerize',
                'release_year' => 2005,
                'genre' => 'Alternative Metal'
            ],
            [
                'artist_id' => 10,
                'title' => 'Hypnotize',
                'release_year' => 2005,
                'genre' => 'Alternative Metal'
            ],

            // Slipknot
            [
                'artist_id' => 11,
                'title' => 'Slipknot',
                'release_year' => 1999,
                'genre' => 'Nu Metal'
            ],
            [
                'artist_id' => 11,
                'title' => 'Iowa',
                'release_year' => 2001,
                'genre' => 'Nu Metal'
            ],
            [
                'artist_id' => 11,
                'title' => 'Vol. 3: (The Subliminal Verses)',
                'release_year' => 2004,
                'genre' => 'Nu Metal'
            ],

            // Avenged Sevenfold
            [
                'artist_id' => 12,
                'title' => 'City of Evil',
                'release_year' => 2005,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 12,
                'title' => 'Avenged Sevenfold',
                'release_year' => 2007,
                'genre' => 'Heavy Metal'
            ],
            [
                'artist_id' => 12,
                'title' => 'Nightmare',
                'release_year' => 2010,
                'genre' => 'Heavy Metal'
            ],

            // Dave Grohl
            [
                'artist_id' => 13,
                'title' => 'Foo Fighters',
                'release_year' => 1995,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 13,
                'title' => 'The Colour and the Shape',
                'release_year' => 1997,
                'genre' => 'Rock'
            ],
            [
                'artist_id' => 13,
                'title' => 'Wasting Light',
                'release_year' => 2011,
                'genre' => 'Rock'
            ],

            // Angus Young (AC/DC)
            [
                'artist_id' => 14,
                'title' => 'Back in Black',
                'release_year' => 1980,
                'genre' => 'Hard Rock'
            ],
            [
                'artist_id' => 14,
                'title' => 'Highway to Hell',
                'release_year' => 1979,
                'genre' => 'Hard Rock'
            ],
            [
                'artist_id' => 14,
                'title' => 'For Those About to Rock We Salute You',
                'release_year' => 1981,
                'genre' => 'Hard Rock'
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
