<?php
require_once __DIR__ . '/../../Models/User.php';

$isLoggedIn = isset($_SESSION['user_id']);
$username = '';

if ($isLoggedIn)
{
    $user_id = $_SESSION['user_id'];
    $user = User::getUserById($userId);
    if ($user)
        $username = $user->username ?? '';
}
?>
<h1>
    Admin Dashboard
</h1>
<h2>
   Welcome, 
    <span style="color: grey">
    <?php
        echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    ?></span>
</h2>

<p> 
    This is your dashboard. From here you can manage your account and do
    all your actions.
</p>

<div>
    <a href="/users">Manage users</a> <br />
    <a href="/admin/analytics">View analytics</a> <br />
</div>

