<?php
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<h1>Music Label Manager</h1>
<p>
    Welcome, this is a platform for managing artist, producers and labels.
    You can register as an artist / producer / listener and join this musical community.
</p>

<p>
    This is a place for music labels to organize their workflow and
    collaboration with artists around the world.
</p>


<?php if (!$isLoggedIn): ?>
    <h1>Register in the platform</h1>
    <div>
        Are you a listener? <a href="/register">Create listener account</a> <br />
        Are you an artist? <a href="/register_artist">Create artist account</a> <br />
        Are you a producer? <a href="/register_producer">Create producer account</a> <br />
        If you already have an account, <a href="/login">login</a>.
    </div>
<?php endif; ?>