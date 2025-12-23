<?php
require_once __DIR__ . '/Model.php';

class Album extends Model
{
    private static string $table = "albums";

    public int $id = 0;
    public int $artist_id = 0;
    public string $title = "";
    public ?int $release_year = null;
    public string $genre = "";
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(array $data = [])
    {
        if (!empty($data))
        {
            $this->id = (int)($data['id'] ?? 0);
            $this->artist_id = (int)($data['artist_id'] ?? 0);
            $this->title = $data['title'] ?? '';
            $this->release_year = isset($data['release_year']) ? (int)$data['release_year'] : null;
            $this->genre = $data['genre'] ?? '';
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
        }
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public static function getAlbumById(int $id): ?Album
    {
        $model = new self();
        $albumData = $model->getById(self::$table, $id);
        return $albumData ? self::fromArray($albumData) : null;
    }

    public static function createAlbum(int $artist_id, string $title, ?int $release_year = null, string $genre = ''): int
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("INSERT INTO " . self::$table . " (artist_id, title, release_year, genre) VALUES (:artist_id, :title, :release_year, :genre)");
        $stmt->execute([
            ':artist_id' => $artist_id,
            ':title' => $title,
            ':release_year' => $release_year,
            ':genre' => $genre
        ]);

        return (int)$pdo->lastInsertId();
    }

    public static function updateAlbum(int $id, int $artist_id, string $title, ?int $release_year = null, string $genre = ''): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("UPDATE " . self::$table . " SET artist_id = :artist_id, title = :title, release_year = :release_year, genre = :genre, updated_at = NOW() WHERE id = :id");
        $result = $stmt->execute([
            ':id' => $id,
            ':artist_id' => $artist_id,
            ':title' => $title,
            ':release_year' => $release_year,
            ':genre' => $genre
        ]);

        return $result && $stmt->rowCount() > 0;
    }

    public static function deleteAlbum(int $id): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM " . self::$table . " WHERE id = :id");
        $result = $stmt->execute([':id' => $id]);

        return $result && $stmt->rowCount() > 0;
    }

    public static function getAll(): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->query("SELECT * FROM " . self::$table);
        if ($stmt === false)
        {
            return [];
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByArtistId(int $artist_id): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE artist_id = :artist_id");
        $stmt->execute([':artist_id' => $artist_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getAllWithArtistName(): array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT al.id, al.artist_id, ar.stage_name AS artist_name, al.title, al.release_year, al.genre
            FROM " . self::$table . " al
            JOIN artists ar ON al.artist_id = ar.id
            ORDER BY al.title ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
