<h2>Create an album</h2>

<form action="/artist/<?php echo $artist_id; ?>/album/store" method="POST">
    <div>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
    </div>

    <div>
        <label for="release_year">Release year:</label>
        <input type="number" name="release_year" id="release_year" required>
    </div>

    <div>
        <label for="genre">Genre</label>
        <input type="text" name="genre" id="genre" required>
    </div>

    <div>
        <button type="submit">Create Album</button>
        <a href="/artist/<?= $artist_id ?>/album">Cancel</a>
    </div>
</form>
