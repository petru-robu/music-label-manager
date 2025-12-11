<?php
require_once __DIR__ . "/../../Models/Artist.php";
$user_id = $_SESSION['user_id'];
$artist = Artist::getByUserId($user_id);
?>

<h1>
    Artist Dashboard

</h1>
<h2>
    Welcome,
    <span style="color: grey">
        <?php
        echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
        ?>
    </span>
</h2>

<p>
    This is your dashboard. From here you can manage your account and do
    all your actions.
</p>

<div>
    <a href="/artist/<?= $artist->id ?>/album">Manage your albums</a>
</div>