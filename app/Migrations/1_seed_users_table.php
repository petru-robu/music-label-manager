<?php

require_once __DIR__ . '/../Database.php';

return new class 
{
    public function up()
    {
        $pdo = Database::getConnection();

        $users = [
            [
                'role_id' => 1,
                'username' => 'admin',
                'email' => 'admin@example.com',
                'full_name' => 'Administrator',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'user1',
                'email' => 'user1@example.com',
                'full_name' => 'Default User',
                'password_hash' => password_hash('user123', PASSWORD_DEFAULT),
            ],
        ];

        $stmt = $pdo->prepare("
            INSERT INTO users (role_id, username, email, full_name, password_hash)
            VALUES (:role_id, :username, :email, :full_name, :password_hash)
        ");

        foreach ($users as $user) {
            $stmt->execute($user);
        }
    }

    public function down()
    {
        $pdo = Database::getConnection();
        
        $emails = ['admin@example.com', 'user1@example.com'];
        $in  = str_repeat('?,', count($emails) - 1) . '?';
        $stmt = $pdo->prepare("DELETE FROM users WHERE email IN ($in)");
        $stmt->execute($emails);
    }
};

