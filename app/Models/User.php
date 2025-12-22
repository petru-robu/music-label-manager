<?php

require_once __DIR__ . '/Model.php';

class User extends Model
{
    private static string $table = 'users';

    public int $id = 0;
    public int $role_id = 1;
    public string $username = '';
    public string $email = '';
    public string $full_name = '';
    public string $password_hash = '';
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(array $data = [])
    {
        if (!empty($data))
        {
            $this->id = (int)($data['id'] ?? 0);
            $this->role_id = (int)($data['role_id'] ?? 1);
            $this->username = $data['username'] ?? '';
            $this->email = $data['email'] ?? '';
            $this->full_name = $data['full_name'] ?? '';
            $this->password_hash = $data['password_hash'] ?? '';
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
        }
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public static function getUserById(int $id): ?User
    {
        $model = new self();
        $userData = $model->getById(self::$table, $id);
        return $userData ? self::fromArray($userData) : null;
    }

    public static function createUser(string $username, string $full_name, string $email, string $password, int $role = 1)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("INSERT INTO " . self::$table .
            " (role_id, username, email, password_hash, full_name) VALUES (:role_id, :username, :email, :password_hash, :full_name)");

        $stmt->execute([
            ':role_id' => $role,
            ':username' => $username,
            ':email' => $email,
            ':password_hash' => $hash,
            ':full_name' => $full_name
        ]);

        return (int)$pdo->lastInsertId();
    }

    public static function usernameExists($username)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT 1 FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn();
    }

    public static function getByUsername(string $username)
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . "  WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? self::fromArray($user) : null;
    }

    public static function emailExists($email)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT 1 FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn();
    }

    public static function getByEmail(string $email)
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . "  WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? self::fromArray($user) : null;
    }

    public static function updateUser(int $id, int $role_id, string $username, string $full_name, string $email, ?string $password = null)
    {
        $pdo = Database::getConnection();

        if ($password)
        {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE " . self::$table . " SET role_id = :role_id, username = :username, full_name = :full_name, 
            email = :email, password_hash = :password_hash, updated_at = NOW() WHERE id = :id");
            $result = $stmt->execute([
                ':id' => $id,
                ':role_id' => $role_id,
                ':username' => $username,
                ':full_name' => $full_name,
                ':email' => $email,
                ':password_hash' => $hash
            ]);
        }
        else
        {
            $stmt = $pdo->prepare("UPDATE " . self::$table . " SET role_id = :role_id, username = :username, 
                full_name = :full_name, email = :email, updated_at = NOW() WHERE id = :id");

            $result = $stmt->execute([
                ':id' => $id,
                ':role_id' => $role_id,
                ':username' => $username,
                ':full_name' => $full_name,
                ':email' => $email
            ]);
        }

        return $result && $stmt->rowCount() > 0;
    }

    public static function deleteUser(int $id)
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("DELETE FROM " . self::$table . " WHERE id = :id");
        $result = $stmt->execute([':id' => $id]);

        return $result && $stmt->rowCount() > 0;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }


    public function getAll(): array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT * FROM " . self::$table;
        $stmt = $pdo->query($sql);

        if ($stmt === false)
            return [];

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}




