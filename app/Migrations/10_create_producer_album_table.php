<?php

require_once __DIR__ . '/../Database.php';

return new class
{
    public function up()
    {
        $pdo = Database::getConnection();

        $sql = "
            CREATE TABLE IF NOT EXISTS producer_album (
                id INT AUTO_INCREMENT PRIMARY KEY,
                producer_id INT NOT NULL,
                artist_id INT NOT NULL,
                album_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY unique_production (producer_id, album_id),
                FOREIGN KEY (producer_id) REFERENCES producers(id) ON DELETE CASCADE,
                FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE CASCADE,
                FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE CASCADE
            )
        ";

        $pdo->exec($sql);
    }

    public function down()
    {
        $pdo = Database::getConnection();
        $sql = "DROP TABLE IF EXISTS producer_album";
        $pdo->exec($sql);
    }
};
