<?php

namespace App;

class Database
{
    public static $pdo = null;

    public static function getConnection(): \PDO
    {
        // Return existing connection if already established
        if (self::$pdo) {
            return self::$pdo;
        }

        // Retrieve credentials using getenv()
        $host = getenv('DB_HOST');
        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');
        $charset = 'utf8mb4';

        // Construct the DSN - data source name
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $opts = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        self::$pdo = new \PDO($dsn, $user, $pass, $opts);

        return self::$pdo;
    }
}
