<?php

require_once __DIR__ . '/../Database.php';

return new class 
{
    public function up()
    {
        $pdo = Database::getConnection();

        $sql = "
            CREATE TABLE IF NOT EXISTS producers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL UNIQUE,
                studio_name VARCHAR(255) NOT NULL,
                bio TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ";

        $pdo->exec($sql);
    }

    public function down()
    {
        $pdo = Database::getConnection();
        $sql = "DROP TABLE IF EXISTS producers";
        $pdo->exec($sql);
    }
};
