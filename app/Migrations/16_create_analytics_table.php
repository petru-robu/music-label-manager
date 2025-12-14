<?php

require_once __DIR__ . '/../Database.php';

return new class
{
    public function up()
    {
        $pdo = Database::getConnection();

        $sql = "
            CREATE TABLE IF NOT EXISTS analytics_visits (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                page VARCHAR(255) NOT NULL,
                ip VARBINARY(16) NOT NULL,
                user_agent VARCHAR(255) NULL,
                referrer VARCHAR(255) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_page (page),
                INDEX idx_created_at (created_at),
                INDEX idx_ip_page_time (ip, page, created_at)
            )
        ";

        $pdo->exec($sql);
    }

    public function down()
    {
        $pdo = Database::getConnection();

        $sql = "
            DROP TABLE IF EXISTS analytics_visits
        ";

        $pdo->exec($sql);
    }
};
