<?php

require_once __DIR__ . '/../Database.php';

return new class
{
    public function up()
    {
        $pdo = Database::getConnection();

        $producers = [
            [
                'user_id' => 13,
                'studio_name' => 'Rick Rubin Studios',
                'bio' => 'Legendary producer known for working across genres from hip-hop to rock.',
            ],
            [
                'user_id' => 14,
                'studio_name' => 'Pharrell Williams Productions',
                'bio' => 'Grammy-winning producer and artist, known for his innovative pop and R&B hits.',
            ],
            [
                'user_id' => 15,
                'studio_name' => 'Timbaland Productions',
                'bio' => 'Influential hip-hop and R&B producer, famous for distinctive beats and collaborations.',
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
