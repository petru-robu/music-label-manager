<?php

require_once __DIR__.'/../Database.php';

class Model
{
    protected function query(string $sql, array $params = []): \PDOStatement|bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    protected function getById(string $table, int $id): ?array
    {
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        $stmt = $this->query($sql, ['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }
}
