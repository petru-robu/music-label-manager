<?php
    require_once __DIR__ . '/../../Models/Artist.php';
    require_once __DIR__ . '/../../Models/User.php';
    $artist = Artist::getArtistById($artist_id);
    $stage_name = $artist->stage_name;

    $user_id = $_SESSION['user_id'];
    $user = User::getUserById($user_id);    
?>

<h2>Releases from <span style="color: grey"><?php echo htmlspecialchars($user->full_name, ENT_QUOTES, 'UTF-8'); ?></span></h2>

<a href="/dashboard">Back to dashboard</a> <br/>
<a href="/artist/<?= $artist->id ?>/album/create">Create a new album</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Artist ID</th>
            <th>Title</th>
            <th>Release Year</th>
            <th>Genre</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Songs</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($albums as $album): ?>
            <tr>
                <td><?= htmlspecialchars($album['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($album['artist_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($album['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($album['release_year'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($album['genre'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><a href="/artist/<?= $artist_id ?>/album/<?= $album['id'] ?>/view">View</a></td>
                <td><a href="/artist/<?= $artist_id ?>/album/<?= $album['id'] ?>/edit">Edit</a></td>
                <td>
                    <a href="/artist/<?= $artist_id ?>/album/<?= $album['id'] ?>/delete"
                       onclick="return confirm('Are you sure you want to delete this album?');">
                        Delete
                    </a>
                </td>
                <td><a href="/artist/<?= $artist_id ?>/album/<?= $album['id'] ?>/song">Songs</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
