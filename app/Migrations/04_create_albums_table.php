<?php

require_once __DIR__ . '/../Database.php';

return new class 
{
    public function up()
    {
        $pdo = Database::getConnection();

        $sql = "
            CREATE TABLE IF NOT EXISTS albums (
                id INT AUTO_INCREMENT PRIMARY KEY,
                artist_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                release_year YEAR,
                genre VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE CASCADE
            )
        ";

        $pdo->exec($sql);
    }

    public function down()
    {
        $pdo = Database::getConnection();

        $sql = "
            DROP TABLE IF EXISTS albums
        ";
        $pdo->exec($sql);
    }   
};
