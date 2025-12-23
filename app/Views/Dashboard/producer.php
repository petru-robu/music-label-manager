<?php
require_once __DIR__ . '/../../Models/User.php';
require_once __DIR__ . "/../../Models/Producer.php";

if ($isLoggedIn)
{
    $user_id = $_SESSION['user_id'];
    $user = User::getUserById($userId);
    if ($user)
        $username = $user->username ?? '';

    $producer = Producer::getByUserId($user_id);
}
?>

<h1>
    Producer Dashboard
</h1>

<h2>
    Welcome,
    <span style="color: grey">
        <?php
        echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        ?>
    </span>
</h2>

<p>
    This is your dashboard. From here you can manage your account and do
    all your actions.
</p>

<div>
    <a href="/profile/edit">Edit profile</a> <br />
    <a href="/producer/<?= $producer->id ?>/album">Manage your productions</a>

</div>
