<?php

require_once __DIR__ . '/Model.php';

class ProducerAlbum extends Model
{
    private static string $table = "producer_album";

    public int $id = 0;
    public int $producer_id = 0;
    public int $artist_id = 0;
    public int $album_id = 0;
    public ?string $created_at = null;

    public function __construct(array $data = [])
    {
        if (!empty($data))
        {
            $this->id = (int)($data['id'] ?? 0);
            $this->producer_id = (int)($data['producer_id'] ?? 0);
            $this->artist_id = (int)($data['artist_id'] ?? 0);
            $this->album_id = (int)($data['album_id'] ?? 0);
            $this->created_at = $data['created_at'] ?? null;
        }
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public static function create(int $producer_id, int $artist_id, int $album_id): int
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO " . self::$table . " (producer_id, artist_id, album_id)
            VALUES (:producer_id, :artist_id, :album_id)
        ");
        $stmt->execute([
            ':producer_id' => $producer_id,
            ':artist_id' => $artist_id,
            ':album_id' => $album_id
        ]);

        return (int)$pdo->lastInsertId();
    }

    public static function getAllByProducer(int $producer_id): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE producer_id = :producer_id");
        $stmt->execute([':producer_id' => $producer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllByProducerWithNames(int $producer_id): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT pa.*, a.stage_name AS artist_name, al.title AS album_title
            FROM producer_album pa
            JOIN artists a ON pa.artist_id = a.id
            JOIN albums al ON pa.album_id = al.id
            WHERE pa.producer_id = :producer_id
            ORDER BY pa.created_at DESC
        ");
        $stmt->execute([':producer_id' => $producer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(int $id): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("DELETE FROM producer_album WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }

    public static function deleteByProducerAlbum(int $producer_id, int $album_id): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            DELETE FROM producer_album 
            WHERE producer_id = :producer_id AND album_id = :album_id
        ");
        $stmt->execute([
            ':producer_id' => $producer_id,
            ':album_id' => $album_id
        ]);

        return $stmt->rowCount() > 0;
    }



}
