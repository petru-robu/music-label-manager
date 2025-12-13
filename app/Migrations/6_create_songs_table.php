<?php

require_once __DIR__ . '/../Database.php';

return new class
{
    public function up()
    {
        $pdo = Database::getConnection();

        $sql = "
            CREATE TABLE IF NOT EXISTS songs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                album_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                duration INT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE CASCADE
            )
        ";

        $pdo->exec($sql);
    }

    public function down()
    {
        $pdo = Database::getConnection();

        $sql = "
            DROP TABLE IF EXISTS songs
        ";

        $pdo->exec($sql);
    }
};
