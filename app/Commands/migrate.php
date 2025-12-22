<?php
// have to include env here, because it is run in CLI
require_once __DIR__ . '/../../vendor/autoload.php';
$root = dirname(__DIR__, 2);
$dotenv = Dotenv\Dotenv::createImmutable($root);
$dotenv->load();

require_once __DIR__ . '/../Database.php';
$pdo = Database::getConnection();
$migrationsDir = __DIR__ . '/../Migrations/';

// Create the migrations table
$sql = "
    CREATE TABLE IF NOT EXISTS migrations (
        name VARCHAR(255) PRIMARY KEY,
        applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
$pdo->exec($sql);

$sql = "SELECT name FROM migrations";
$applied = $pdo->query($sql)->fetchAll(PDO::FETCH_COLUMN);

// try applying all migrations in migrations directory
foreach (scandir($migrationsDir) as $file)
{
    if (pathinfo($file, PATHINFO_EXTENSION) != 'php')
        continue;

    if (in_array($file, $applied))
        continue;

    $migration = require $migrationsDir . $file;
    $migration->up($pdo);

    $stmt = $pdo->prepare("INSERT INTO migrations (name) VALUES (:name)");
    $stmt->execute(['name' => $file]);

    echo "Applied: $file\n";
}