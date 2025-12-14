<?php
require_once __DIR__ . '/Model.php';

class Analytics extends Model
{
    private static string $table = 'analytics_visits';

    public int $id = 0;
    public string $page = '';
    public string $ip = '';
    public ?string $user_agent = null;
    public ?string $referrer = null;
    public ?string $created_at = null;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = (int) ($data['id'] ?? 0);
            $this->page = $data['page'] ?? '';
            $this->ip = $data['ip'] ?? '';
            $this->user_agent = $data['user_agent'] ?? null;
            $this->referrer = $data['referrer'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
        }
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public static function getTotals(): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->query("
            SELECT
                COUNT(*) AS total_views,
                COUNT(DISTINCT ip) AS unique_visitors
            FROM " . self::$table
        );

        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : [];
    }

    public static function getViewsPerDay(int $limit = 14): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT DATE(created_at) AS day, COUNT(*) AS views
            FROM " . self::$table . "
            GROUP BY day
            ORDER BY day DESC
            LIMIT :limit
        ");

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTopPages(int $limit = 10): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT page, COUNT(*) AS views
            FROM " . self::$table . "
            GROUP BY page
            ORDER BY views DESC
            LIMIT :limit
        ");

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function purgeOlderThan(int $days): int
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            DELETE FROM " . self::$table . "
            WHERE created_at < (NOW() - INTERVAL :days DAY)
        ");

        $stmt->bindValue(':days', $days, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
