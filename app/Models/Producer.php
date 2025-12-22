<?php

require_once __DIR__ . '/Model.php';

class Producer extends Model
{
    private static string $table = "producers";

    public int $id = 0;
    public int $user_id = 0;
    public string $studio_name = "";
    public string $bio = "";
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(array $data = [])
    {
        if (!empty($data))
        {
            $this->id = (int)($data['id'] ?? 0);
            $this->user_id = (int)($data['user_id'] ?? 0);
            $this->studio_name = $data['studio_name'] ?? '';
            $this->bio = $data['bio'] ?? '';
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
        }
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public static function getProducerById(int $id): ?Producer
    {
        $model = new self();
        $producerData = $model->getById(self::$table, $id);
        return $producerData ? self::fromArray($producerData) : null;
    }

    public static function createProducer(int $user_id, string $studio_name, string $bio = ''): int
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("INSERT INTO " . self::$table . " (user_id, studio_name, bio) VALUES (:user_id, :studio_name, :bio)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':studio_name' => $studio_name,
            ':bio' => $bio
        ]);

        return (int)$pdo->lastInsertId();
    }

    public static function updateProducer(int $id, int $user_id, string $studio_name, string $bio = ''): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("UPDATE " . self::$table . " SET user_id = :user_id, studio_name = :studio_name, bio = :bio, updated_at = NOW() WHERE id = :id");
        $result = $stmt->execute([
            ':id' => $id,
            ':user_id' => $user_id,
            ':studio_name' => $studio_name,
            ':bio' => $bio
        ]);

        return $result && $stmt->rowCount() > 0;
    }

    public static function deleteProducer(int $id): bool
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

    public static function getByUserId(int $user_id): ?Producer
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $producer = $stmt->fetch(PDO::FETCH_ASSOC);

        return $producer ? self::fromArray($producer) : null;
    }
}
