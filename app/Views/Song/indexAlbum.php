<?php
    require_once __DIR__ . '/../../Models/Album.php';
    require_once __DIR__ . '/../../Models/User.php';
    $album = Album::getAlbumById($album_id);
?>


<h2>Songs in <span style="color: grey"><?php echo $album->title; ?></span></h2>

<a href="/artist/<?= $artist_id ?>/album">Back to albums</a> <br/>
<a href="/artist/<?= $artist_id ?>/album/<?= $album_id ?>/song/create">Add New Song</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Duration (sec)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($songs as $song): ?>
            <tr>
                <td><?= $song['id'] ?></td>
                <td><?= htmlspecialchars($song['title']) ?></td>
                <td><?= $song['duration'] ?? '-' ?></td>
                <td>
                    <a href="/artist/<?= $artist_id ?>/album/<?= $album_id ?>/song/<?= $song['id'] ?>/edit">Edit</a>
                    <a href="/artist/<?= $artist_id ?>/album/<?= $album_id ?>/song/<?= $song['id'] ?>/delete"
                        onclick="return confirm('Are you sure you want to delete this song?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>