<?php

require_once __DIR__ . '/../Database.php';

class AnalyticsTracker
{
    public static function track(): void
    {
        if (php_sapi_name() === 'cli') {
            return;
        }

        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        if (preg_match('/bot|crawl|spider|slurp|bing|google/i', $ua)) {
            return;
        }

        $pdo = Database::getConnection();
        if (!$pdo) {
            return;
        }

        $ip = inet_pton($_SERVER['REMOTE_ADDR']);
        $page = strtok($_SERVER['REQUEST_URI'], '?');
        $referrer = $_SERVER['HTTP_REFERER'] ?? null;

        $sql = "
            SELECT 1
            FROM analytics_visits
            WHERE ip = :ip
              AND page = :page
              AND created_at > (NOW() - INTERVAL 10 MINUTE)
            LIMIT 1
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':ip' => $ip,
            ':page' => $page,
        ]);

        if (!$stmt->fetchColumn()) {
            $sql = "
                INSERT INTO analytics_visits (page, ip, user_agent, referrer)
                VALUES (:page, :ip, :ua, :ref)
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':page' => $page,
                ':ip' => $ip,
                ':ua' => $ua,
                ':ref' => $referrer,
            ]);
        }
    }
}
