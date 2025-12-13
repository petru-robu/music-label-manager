<h2>Update an album</h2>

<form action="/artist/<?php echo $artist_id; ?>/album/<?php echo $album->id; ?>/update" method="POST">
    <div>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($album->title, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div>
        <label for="release_year">Release year:</label>
        <input type="number" name="release_year" id="release_year" value="<?php echo htmlspecialchars($album->release_year, ENT_QUOTES, 'UTF-8'); ?>"  required>
    </div>

    <div>
        <label for="genre">Genre</label>
        <input type="text" name="genre" id="genre" value="<?php echo htmlspecialchars($album->genre, ENT_QUOTES, 'UTF-8'); ?>"  required>
    </div>

    <div>
        <button type="submit">Update Album</button>
        <a href="/artist/<?= $artist_id ?>/album">Cancel</a>
    </div>
</form>
