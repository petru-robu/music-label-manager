<?php

require_once __DIR__ . '/../Database.php';

return new class 
{
    public function up()
    {
        $pdo = Database::getConnection();

        $artists = [
            [
            'user_id' => 11,
            'stage_name' => 'Jimmy Hendrix',
            'bio' => 'This is my biography.',
            ],

            [
            'user_id' => 10,
            'stage_name' => 'Michael Jackson',
            'bio' => 'This is my biography, I am M.J.',
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