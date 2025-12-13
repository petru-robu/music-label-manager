<?php
require_once __DIR__ . '/Model.php';

class Song extends Model
{
    private static string $table = "songs";

    public int $id = 0;
    public int $album_id = 0;
    public string $title = "";
    public ?int $duration = null; // seconds
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = (int) ($data['id'] ?? 0);
            $this->album_id = (int) ($data['album_id'] ?? 0);
            $this->title = $data['title'] ?? '';
            $this->duration = isset($data['duration']) ? (int) $data['duration'] : null;
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
        }
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public static function getSongById(int $id): ?Song
    {
        $model = new self();
        $songData = $model->getById(self::$table, $id);
        return $songData ? self::fromArray($songData) : null;
    }

    public static function createSong(int $album_id, string $title, ?int $duration = null): int
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            "INSERT INTO " . self::$table . " (album_id, title, duration)
             VALUES (:album_id, :title, :duration)"
        );

        $stmt->execute([
            ':album_id' => $album_id,
            ':title' => $title,
            ':duration' => $duration
        ]);

        return (int) $pdo->lastInsertId();
    }

    public static function updateSong(int $id, string $title, ?int $duration = null): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            "UPDATE " . self::$table . "
             SET title = :title,
                 duration = :duration,
                 updated_at = NOW()
             WHERE id = :id"
        );

        $result = $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':duration' => $duration
        ]);

        return $result && $stmt->rowCount() > 0;
    }

    public static function deleteSong(int $id): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            "DELETE FROM " . self::$table . " WHERE id = :id"
        );

        $result = $stmt->execute([':id' => $id]);

        return $result && $stmt->rowCount() > 0;
    }

    public static function getAll(): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->query("SELECT * FROM " . self::$table);
        if ($stmt === false) {
            return [];
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByAlbumId(int $album_id): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            "SELECT * FROM " . self::$table . " WHERE album_id = :album_id"
        );
        $stmt->execute([':album_id' => $album_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
