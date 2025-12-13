<h1>Edit Song</h1>

<form method="POST" action="/artist/<?= $artist_id ?>/album/<?= $album_id ?>/song/<?= $song->id ?>/update">
    <div>
        <label for="title">Song Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($song->title) ?>" required>
    </div>
    <div>
        <label for="duration">Duration (seconds):</label>
        <input type="number" id="duration" name="duration" value="<?= $song->duration ?? '' ?>" min="0">
    </div>
    <div>
        <button type="submit">Update Song</button>
        <a href="/artist/<?= $artist_id ?>/album/<?= $album_id ?>/song">Cancel</a>
    </div>
</form>