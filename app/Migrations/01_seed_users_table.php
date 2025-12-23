<?php

require_once __DIR__ . '/../Database.php';

return new class
{
    public function up()
    {
        $pdo = Database::getConnection();

        $users = [
            // admin
            [
            'role_id' => 1,
            'username' => 'admin',
            'email' => 'admin@example.com',
            'full_name' => 'Administrator',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],

            // listeners
            [
            'role_id' => 3,
            'username' => 'listener1',
            'email' => 'listener1@example.com',
            'full_name' => 'Listener One',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 3,
            'username' => 'listener2',
            'email' => 'listener2@example.com',
            'full_name' => 'Listener Two',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],

            // artists (15 metal/hard rock bands + solo artists)
            [
            'role_id' => 2,
            'username' => 'metallica',
            'email' => 'metallica@example.com',
            'full_name' => 'Metallica',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'ironmaiden',
            'email' => 'ironmaiden@example.com',
            'full_name' => 'Iron Maiden',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'slayer',
            'email' => 'slayer@example.com',
            'full_name' => 'Slayer',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'megadeth',
            'email' => 'megadeth@example.com',
            'full_name' => 'Megadeth',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'pantera',
            'email' => 'pantera@example.com',
            'full_name' => 'Pantera',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'blacksabbath',
            'email' => 'blacksabbath@example.com',
            'full_name' => 'Black Sabbath',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'ozzyosbourne',
            'email' => 'ozzyosbourne@example.com',
            'full_name' => 'Ozzy Osbourne',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'judaspriest',
            'email' => 'judaspriest@example.com',
            'full_name' => 'Judas Priest',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'motorhead',
            'email' => 'motorhead@example.com',
            'full_name' => 'Motörhead',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'systemofadown',
            'email' => 'systemofadown@example.com',
            'full_name' => 'System of a Down',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'slipknot',
            'email' => 'slipknot@example.com',
            'full_name' => 'Slipknot',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'avengedsevenfold',
            'email' => 'avengedsevenfold@example.com',
            'full_name' => 'Avenged Sevenfold',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'davegrohl',
            'email' => 'davegrohl@example.com',
            'full_name' => 'Dave Grohl',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 2,
            'username' => 'angusyoung',
            'email' => 'angusyoung@example.com',
            'full_name' => 'Angus Young',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],

            // producers (metal/hard rock)
            [
            'role_id' => 4,
            'username' => 'rickrubin',
            'email' => 'rickrubin@example.com',
            'full_name' => 'Rick Rubin',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 4,
            'username' => 'bobrock',
            'email' => 'bobrock@example.com',
            'full_name' => 'Bob Rock',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 4,
            'username' => 'terrydate',
            'email' => 'terrydate@example.com',
            'full_name' => 'Terry Date',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 4,
            'username' => 'andywallace',
            'email' => 'andywallace@example.com',
            'full_name' => 'Andy Wallace',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
            'role_id' => 4,
            'username' => 'stevemodest',
            'email' => 'stevemodest@example.com',
            'full_name' => 'Steve Modest',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
        ];


        $stmt = $pdo->prepare("
            INSERT INTO users (role_id, username, email, full_name, password_hash)
            VALUES (:role_id, :username, :email, :full_name, :password_hash)
        ");

        foreach ($users as $user)
        {
            $stmt->execute($user);
        }
    }

    public function down()
    {
        $pdo = Database::getConnection();

        $emails = ['admin@example.com', 'user1@example.com'];
        $in = str_repeat('?,', count($emails) - 1) . '?';
        $stmt = $pdo->prepare("DELETE FROM users WHERE email IN ($in)");
        $stmt->execute($emails);
    }
};

