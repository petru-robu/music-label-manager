<?php

require_once __DIR__ . '/../Database.php';

return new class
{
    public function up()
    {
        $pdo = Database::getConnection();

        $songs = [
            // Metallica – Master of Puppets (album_id = 1)
            ['album_id' => 1, 'title' => 'Battery', 'duration' => 312],
            ['album_id' => 1, 'title' => 'Master of Puppets', 'duration' => 515],
            ['album_id' => 1, 'title' => 'The Thing That Should Not Be', 'duration' => 390],
            ['album_id' => 1, 'title' => 'Welcome Home (Sanitarium)', 'duration' => 387],
            ['album_id' => 1, 'title' => 'Disposable Heroes', 'duration' => 410],

            // Metallica – Ride the Lightning (album_id = 2)
            ['album_id' => 2, 'title' => 'Fight Fire with Fire', 'duration' => 280],
            ['album_id' => 2, 'title' => 'Ride the Lightning', 'duration' => 406],
            ['album_id' => 2, 'title' => 'For Whom the Bell Tolls', 'duration' => 312],
            ['album_id' => 2, 'title' => 'Fade to Black', 'duration' => 417],
            ['album_id' => 2, 'title' => 'Creeping Death', 'duration' => 380],

            // Metallica – ...And Justice for All (album_id = 3)
            ['album_id' => 3, 'title' => 'Blackened', 'duration' => 399],
            ['album_id' => 3, 'title' => '…And Justice for All', 'duration' => 570],
            ['album_id' => 3, 'title' => 'Eye of the Beholder', 'duration' => 375],
            ['album_id' => 3, 'title' => 'One', 'duration' => 447],
            ['album_id' => 3, 'title' => 'Dyers Eve', 'duration' => 335],

            // Iron Maiden – The Number of the Beast (album_id = 4)
            ['album_id' => 4, 'title' => 'Invaders', 'duration' => 215],
            ['album_id' => 4, 'title' => 'Children of the Damned', 'duration' => 310],
            ['album_id' => 4, 'title' => 'The Prisoner', 'duration' => 250],
            ['album_id' => 4, 'title' => '22 Acacia Avenue', 'duration' => 280],
            ['album_id' => 4, 'title' => 'Hallowed Be Thy Name', 'duration' => 430],

            // Iron Maiden – Powerslave (album_id = 5)
            ['album_id' => 5, 'title' => 'Aces High', 'duration' => 310],
            ['album_id' => 5, 'title' => '2 Minutes to Midnight', 'duration' => 320],
            ['album_id' => 5, 'title' => 'Losfer Words', 'duration' => 270],
            ['album_id' => 5, 'title' => 'Back in the Village', 'duration' => 220],
            ['album_id' => 5, 'title' => 'Powerslave', 'duration' => 395],

            // Iron Maiden - Piece of Mind (album_id = 6)
            ['album_id' => 6, 'title' => 'Where Eagles Dare', 'duration' => 320],
            ['album_id' => 6, 'title' => 'Revelations', 'duration' => 310],
            ['album_id' => 6, 'title' => 'Flight of Icarus', 'duration' => 235],
            ['album_id' => 6, 'title' => 'The Trooper', 'duration' => 250],
            ['album_id' => 6, 'title' => 'Sun and Steel', 'duration' => 350],

            // Slayer – Reign in Blood (album_id = 7)
            ['album_id' => 7, 'title' => 'Angel of Death', 'duration' => 309],
            ['album_id' => 7, 'title' => 'Piece by Piece', 'duration' => 210],
            ['album_id' => 7, 'title' => 'Necrophobic', 'duration' => 180],
            ['album_id' => 7, 'title' => 'Altar of Sacrifice', 'duration' => 220],
            ['album_id' => 7, 'title' => 'Raining Blood', 'duration' => 320],

            // Slayer – South of Heaven (album_id = 8)
            ['album_id' => 8, 'title' => 'South of Heaven', 'duration' => 310],
            ['album_id' => 8, 'title' => 'Silent Scream', 'duration' => 230],
            ['album_id' => 8, 'title' => 'Mandatory Suicide', 'duration' => 240],
            ['album_id' => 8, 'title' => 'Ghosts of War', 'duration' => 210],
            ['album_id' => 8, 'title' => 'Read Between the Lines', 'duration' => 195],

            // Slayer – Seasons in the Abyss (album_id = 9)
            ['album_id' => 9, 'title' => 'War Ensemble', 'duration' => 295],
            ['album_id' => 9, 'title' => 'Dead Skin Mask', 'duration' => 335],
            ['album_id' => 9, 'title' => 'Skeletons of Society', 'duration' => 220],
            ['album_id' => 9, 'title' => 'Seasons in the Abyss', 'duration' => 340],
            ['album_id' => 9, 'title' => 'Temptation', 'duration' => 210],

            // Megadeth – Rust in Peace (album_id = 10)
            ['album_id' => 10, 'title' => 'Holy Wars… The Punishment Due', 'duration' => 330],
            ['album_id' => 10, 'title' => 'Hangar 18', 'duration' => 285],
            ['album_id' => 10, 'title' => 'Take No Prisoners', 'duration' => 310],
            ['album_id' => 10, 'title' => 'Five Magics', 'duration' => 300],
            ['album_id' => 10, 'title' => 'Tornado of Souls', 'duration' => 350],

            // Megadeth – Peace Sells… But Who's Buying? (album_id = 11)
            ['album_id' => 11, 'title' => 'Wake Up Dead', 'duration' => 240],
            ['album_id' => 11, 'title' => 'Peace Sells', 'duration' => 270],
            ['album_id' => 11, 'title' => 'Devil\'s Island', 'duration' => 250],
            ['album_id' => 11, 'title' => 'Good Mourning/Black Friday', 'duration' => 310],
            ['album_id' => 11, 'title' => 'Bad Omen', 'duration' => 280],

            // Megadeth – Countdown to Extinction (album_id = 12)
            ['album_id' => 12, 'title' => 'Skin o\' My Teeth', 'duration' => 220],
            ['album_id' => 12, 'title' => 'Symphony of Destruction', 'duration' => 260],
            ['album_id' => 12, 'title' => 'Architecture of Aggression', 'duration' => 240],
            ['album_id' => 12, 'title' => 'Foreclosure of a Dream', 'duration' => 300],
            ['album_id' => 12, 'title' => 'Sweating Bullets', 'duration' => 300],

            // Pantera – Vulgar Display of Power (album_id = 13)
            ['album_id' => 13, 'title' => 'Mouth for War', 'duration' => 210],
            ['album_id' => 13, 'title' => 'A New Level', 'duration' => 305],
            ['album_id' => 13, 'title' => 'This Love', 'duration' => 280],
            ['album_id' => 13, 'title' => 'Hollow', 'duration' => 320],
            ['album_id' => 13, 'title' => 'Walk', 'duration' => 290],

            // Pantera – Far Beyond Driven (album_id = 14)
            ['album_id' => 14, 'title' => 'Strength Beyond Strength', 'duration' => 240],
            ['album_id' => 14, 'title' => '5 Minutes Alone', 'duration' => 305],
            ['album_id' => 14, 'title' => 'Good Friends and a Bottle of Pills', 'duration' => 200],
            ['album_id' => 14, 'title' => 'Becoming', 'duration' => 300],
            ['album_id' => 14, 'title' => 'Throes of Rejection', 'duration' => 220],

            // Pantera – Cowboys from Hell (album_id = 15)
            ['album_id' => 15, 'title' => 'Cowboys from Hell', 'duration' => 285],
            ['album_id' => 15, 'title' => 'Primal Concrete Sledge', 'duration' => 230],
            ['album_id' => 15, 'title' => 'Psycho Holiday', 'duration' => 310],
            ['album_id' => 15, 'title' => 'Cemetery Gates', 'duration' => 420],
            ['album_id' => 15, 'title' => 'Domination', 'duration' => 325],

            // Black Sabbath – Paranoid (album_id = 16)
            ['album_id' => 16, 'title' => 'War Pigs', 'duration' => 470],
            ['album_id' => 16, 'title' => 'Paranoid', 'duration' => 170],
            ['album_id' => 16, 'title' => 'Planet Caravan', 'duration' => 230],
            ['album_id' => 16, 'title' => 'Iron Man', 'duration' => 355],
            ['album_id' => 16, 'title' => 'Electric Funeral', 'duration' => 270],

            // Black Sabbath – Black Sabbath (album_id = 17)
            ['album_id' => 17, 'title' => 'Black Sabbath', 'duration' => 380],
            ['album_id' => 17, 'title' => 'The Wizard', 'duration' => 260],
            ['album_id' => 17, 'title' => 'Behind the Wall of Sleep', 'duration' => 240],
            ['album_id' => 17, 'title' => 'N.I.B.', 'duration' => 345],
            ['album_id' => 17, 'title' => 'Sleeping Village', 'duration' => 260],

            // Black Sabbath – Sabbath Bloody Sabbath (album_id = 18)
            ['album_id' => 18, 'title' => 'Sabbath Bloody Sabbath', 'duration' => 320],
            ['album_id' => 18, 'title' => 'A National Acrobat', 'duration' => 355],
            ['album_id' => 18, 'title' => 'Fluff', 'duration' => 130],
            ['album_id' => 18, 'title' => 'Who Are You?', 'duration' => 220],
            ['album_id' => 18, 'title' => 'Looking for Today', 'duration' => 190],

            // Ozzy Osbourne – Bark at the Moon (album_id = 19)
            ['album_id' => 19, 'title' => 'Bark at the Moon', 'duration' => 250],
            ['album_id' => 19, 'title' => 'Rock n Roll Rebel', 'duration' => 220],
            ['album_id' => 19, 'title' => 'Now You See It (Now You Dont)', 'duration' => 180],
            ['album_id' => 19, 'title' => 'Waiting for Darkness', 'duration' => 200],
            ['album_id' => 19, 'title' => 'Centre of Eternity', 'duration' => 190],

            // Judas Priest – British Steel (album_id = 20)
            ['album_id' => 20, 'title' => 'Rapid Fire', 'duration' => 240],
            ['album_id' => 20, 'title' => 'Metal Gods', 'duration' => 290],
            ['album_id' => 20, 'title' => 'Breaking the Law', 'duration' => 160],
            ['album_id' => 20, 'title' => 'Grinder', 'duration' => 260],
            ['album_id' => 20, 'title' => 'United', 'duration' => 180],

            // Judas Priest – Painkiller (album_id = 21)
            ['album_id' => 21, 'title' => 'Painkiller', 'duration' => 360],
            ['album_id' => 21, 'title' => 'Hell Patrol', 'duration' => 250],
            ['album_id' => 21, 'title' => 'All Guns Blazing', 'duration' => 220],
            ['album_id' => 21, 'title' => 'Leather Rebel', 'duration' => 200],
            ['album_id' => 21, 'title' => 'A Touch of Evil', 'duration' => 245],

            // Judas Priest – Screaming for Vengeance (album_id = 22)
            ['album_id' => 22, 'title' => 'Electric Eye', 'duration' => 245],
            ['album_id' => 22, 'title' => 'Riding on the Wind', 'duration' => 200],
            ['album_id' => 22, 'title' => 'Bloodstone', 'duration' => 260],
            ['album_id' => 22, 'title' => 'The Hellion', 'duration' => 90],
            ['album_id' => 22, 'title' => 'Screaming for Vengeance', 'duration' => 280],

            // Motörhead – Ace of Spades (album_id = 23)
            ['album_id' => 23, 'title' => 'Ace of Spades', 'duration' => 165],
            ['album_id' => 23, 'title' => 'Love Me Like a Reptile', 'duration' => 200],
            ['album_id' => 23, 'title' => 'Shoot You in the Back', 'duration' => 180],
            ['album_id' => 23, 'title' => 'Live to Win', 'duration' => 210],
            ['album_id' => 23, 'title' => 'The Chase Is Better Than the Catch', 'duration' => 190],

            // Motörhead – Overkill (album_id = 24)
            ['album_id' => 24, 'title' => 'Overkill', 'duration' => 290],
            ['album_id' => 24, 'title' => 'Stay Clean', 'duration' => 180],
            ['album_id' => 24, 'title' => 'No Class', 'duration' => 190],
            ['album_id' => 24, 'title' => 'Damage Case', 'duration' => 210],
            ['album_id' => 24, 'title' => 'Metropolis', 'duration' => 220],

            // Motörhead – Bomber (album_id = 25)
            ['album_id' => 25, 'title' => 'Dead Men Tell No Tales', 'duration' => 200],
            ['album_id' => 25, 'title' => 'Stone Dead Forever', 'duration' => 190],
            ['album_id' => 25, 'title' => 'Bomber', 'duration' => 260],
            ['album_id' => 25, 'title' => 'Lawman', 'duration' => 220],
            ['album_id' => 25, 'title' => 'Sharpshooter', 'duration' => 180],

            // System of a Down – Toxicity (album_id = 26)
            ['album_id' => 26, 'title' => 'Prison Song', 'duration' => 200],
            ['album_id' => 26, 'title' => 'Needles', 'duration' => 190],
            ['album_id' => 26, 'title' => 'Deer Dance', 'duration' => 205],
            ['album_id' => 26, 'title' => 'Toxicity', 'duration' => 230],
            ['album_id' => 26, 'title' => 'Aerials', 'duration' => 285],

            // System of a Down – Mezmerize (album_id = 27)
            ['album_id' => 27, 'title' => 'Soldier Side', 'duration' => 250],
            ['album_id' => 27, 'title' => 'B.Y.O.B.', 'duration' => 245],
            ['album_id' => 27, 'title' => 'Revenga', 'duration' => 210],
            ['album_id' => 27, 'title' => 'Cigaro', 'duration' => 190],
            ['album_id' => 27, 'title' => 'Radio/Video', 'duration' => 200],

            // System of a Down – Hypnotize (album_id = 28)
            ['album_id' => 28, 'title' => 'Attack', 'duration' => 225],
            ['album_id' => 28, 'title' => 'Dreaming', 'duration' => 210],
            ['album_id' => 28, 'title' => 'Kill Rock \'n\' Roll', 'duration' => 200],
            ['album_id' => 28, 'title' => 'Hypnotize', 'duration' => 230],
            ['album_id' => 28, 'title' => 'Lonely Day', 'duration' => 145],

            // Slipknot – Slipknot (album_id = 29)
            ['album_id' => 29, 'title' => '742617000027', 'duration' => 200],
            ['album_id' => 29, 'title' => 'Eyeless', 'duration' => 250],
            ['album_id' => 29, 'title' => 'Wait and Bleed', 'duration' => 230],
            ['album_id' => 29, 'title' => 'Surfacing', 'duration' => 245],
            ['album_id' => 29, 'title' => 'Spit It Out', 'duration' => 220],

            // Slipknot – Iowa (album_id = 30)
            ['album_id' => 30, 'title' => 'People = Shit', 'duration' => 220],
            ['album_id' => 30, 'title' => 'Disasterpiece', 'duration' => 340],
            ['album_id' => 30, 'title' => 'Left Behind', 'duration' => 200],
            ['album_id' => 30, 'title' => 'The Heretic Anthem', 'duration' => 230],
            ['album_id' => 30, 'title' => 'My Plague', 'duration' => 225],

            // Slipknot – Vol. 3: (The Subliminal Verses) (album_id = 31)
            ['album_id' => 31, 'title' => 'Pulse of the Maggots', 'duration' => 210],
            ['album_id' => 31, 'title' => 'Duality', 'duration' => 230],
            ['album_id' => 31, 'title' => 'Vermilion', 'duration' => 240],
            ['album_id' => 31, 'title' => 'Before I Forget', 'duration' => 230],
            ['album_id' => 31, 'title' => 'The Nameless', 'duration' => 210],

            // Avenged Sevenfold – City of Evil (album_id = 32)
            ['album_id' => 32, 'title' => 'Beast and the Harlot', 'duration' => 280],
            ['album_id' => 32, 'title' => 'Burn It Down', 'duration' => 250],
            ['album_id' => 32, 'title' => 'Blinded in Chains', 'duration' => 300],
            ['album_id' => 32, 'title' => 'Bat Country', 'duration' => 310],
            ['album_id' => 32, 'title' => 'Trashed and Scattered', 'duration' => 260],

            // Avenged Sevenfold – Avenged Sevenfold (album_id = 33)
            ['album_id' => 33, 'title' => 'Critical Acclaim', 'duration' => 290],
            ['album_id' => 33, 'title' => 'Almost Easy', 'duration' => 270],
            ['album_id' => 33, 'title' => 'Scream', 'duration' => 260],
            ['album_id' => 33, 'title' => 'Afterlife', 'duration' => 320],
            ['album_id' => 33, 'title' => 'Sidewinder', 'duration' => 240],

            // Avenged Sevenfold – Nightmare (album_id = 34)
            ['album_id' => 34, 'title' => 'Welcome to the Family', 'duration' => 220],
            ['album_id' => 34, 'title' => 'Nightmare', 'duration' => 330],
            ['album_id' => 34, 'title' => 'Danger Line', 'duration' => 280],
            ['album_id' => 34, 'title' => 'So Far Away', 'duration' => 280],
            ['album_id' => 34, 'title' => 'God Hates Us', 'duration' => 250],

            // Dave Grohl – Foo Fighters (album_id = 35)
            ['album_id' => 35, 'title' => 'This Is a Call', 'duration' => 240],
            ['album_id' => 35, 'title' => 'I\'ll Stick Around', 'duration' => 230],
            ['album_id' => 35, 'title' => 'Big Me', 'duration' => 200],
            ['album_id' => 35, 'title' => 'Alone + Easy Target', 'duration' => 210],
            ['album_id' => 35, 'title' => 'Good Grief', 'duration' => 220],

            // Dave Grohl – The Colour and the Shape (album_id = 36)
            ['album_id' => 36, 'title' => 'Monkey Wrench', 'duration' => 230],
            ['album_id' => 36, 'title' => 'Everlong', 'duration' => 255],
            ['album_id' => 36, 'title' => 'My Hero', 'duration' => 250],
            ['album_id' => 36, 'title' => 'Hey, Johnny Park!', 'duration' => 200],
            ['album_id' => 36, 'title' => 'New Way Home', 'duration' => 180],

            // Dave Grohl – Wasting Light (album_id = 37)
            ['album_id' => 37, 'title' => 'Rope', 'duration' => 260],
            ['album_id' => 37, 'title' => 'Bridge Burning', 'duration' => 240],
            ['album_id' => 37, 'title' => 'White Limo', 'duration' => 210],
            ['album_id' => 37, 'title' => 'Arlandria', 'duration' => 230],
            ['album_id' => 37, 'title' => 'These Days', 'duration' => 280],

            // Angus Young – Back in Black (album_id = 38)
            ['album_id' => 38, 'title' => 'Hells Bells', 'duration' => 312],
            ['album_id' => 38, 'title' => 'Shoot to Thrill', 'duration' => 320],
            ['album_id' => 38, 'title' => 'Back in Black', 'duration' => 255],
            ['album_id' => 38, 'title' => 'You Shook Me All Night Long', 'duration' => 210],
            ['album_id' => 38, 'title' => 'Rock and Roll Ain’t Noise Pollution', 'duration' => 240],

            // Angus Young – Highway to Hell (album_id = 39)
            ['album_id' => 39, 'title' => 'Highway to Hell', 'duration' => 208],
            ['album_id' => 39, 'title' => 'Girls Got Rhythm', 'duration' => 210],
            ['album_id' => 39, 'title' => 'Walk All Over You', 'duration' => 220],
            ['album_id' => 39, 'title' => 'Touch Too Much', 'duration' => 240],
            ['album_id' => 39, 'title' => 'If You Want Blood', 'duration' => 200],

            // Angus Young – For Those About to Rock We Salute You (album_id = 40)
            ['album_id' => 40, 'title' => 'For Those About to Rock', 'duration' => 345],
            ['album_id' => 40, 'title' => 'Put the Finger on You', 'duration' => 210],
            ['album_id' => 40, 'title' => 'Inject the Venom', 'duration' => 215],
            ['album_id' => 40, 'title' => 'Let\'s Get It Up', 'duration' => 220],
            ['album_id' => 40, 'title' => 'Snowballed', 'duration' => 230],
        ];

        $stmt = $pdo->prepare("
            INSERT INTO songs (album_id, title, duration)
            VALUES (:album_id, :title, :duration)
        ");

        foreach ($songs as $song)
        {
            $stmt->execute($song);
        }
    }

    public function down()
    {
        $pdo = Database::getConnection();
        $pdo->exec("DELETE FROM songs");
    }
};
