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
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],


            // artists
            [
                'role_id' => 2,
                'username' => 'user1',
                'email' => 'user1@example.com',
                'full_name' => 'Default User',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'mickjagger',
                'email' => 'mickjagger@example.com',
                'full_name' => 'Mick Jagger',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'davidbowie',
                'email' => 'davidbowie@example.com',
                'full_name' => 'David Bowie',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'freddiemercury',
                'email' => 'freddiemercury@example.com',
                'full_name' => 'Freddie Mercury',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'jimmihendrix',
                'email' => 'jimmihendrix@example.com',
                'full_name' => 'Jimi Hendrix',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'janisjoplin',
                'email' => 'janisjoplin@example.com',
                'full_name' => 'Janis Joplin',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'elvispresley',
                'email' => 'elvispresley@example.com',
                'full_name' => 'Elvis Presley',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'johnlennon',
                'email' => 'johnlennon@example.com',
                'full_name' => 'John Lennon',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'paulmccartney',
                'email' => 'paulmccartney@example.com',
                'full_name' => 'Paul McCartney',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'robertplant',
                'email' => 'robertplant@example.com',
                'full_name' => 'Robert Plant',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 2,
                'username' => 'ozzyosbourne',
                'email' => 'ozzyosbourne@example.com',
                'full_name' => 'Ozzy Osbourne',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],


            // producers
            [
                'role_id' => 4,
                'username' => 'rickrubin',
                'email' => 'rickrubin@example.com',
                'full_name' => 'Rick Rubin',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 4,
                'username' => 'pharell',
                'email' => 'pharell@example.com',
                'full_name' => 'Pharell Williams',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'role_id' => 4,
                'username' => 'timbaland',
                'email' => 'timbaland@example.com',
                'full_name' => 'Timbaland',
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

