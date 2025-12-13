<h1>Add New Song</h1>

<form method="POST" action="/artist/<?= $artist_id ?>/album/<?= $album_id ?>/song/store">
    <div>
        <label for="title">Song Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="duration">Duration (seconds):</label>
        <input type="number" id="duration" name="duration" min="0">
    </div>
    <div>
        <button type="submit">Create Song</button>
        <a href="/artist/<?= $artist_id ?>/album/<?= $album_id ?>/song">Cancel</a>
    </div>
</form>
