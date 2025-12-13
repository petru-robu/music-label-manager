<h2>Album List</h2>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Artist ID</th>
            <th>Title</th>
            <th>Release Year</th>
            <th>Genre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($albums as $album): ?>
            <tr>
                <td><?php echo htmlspecialchars($album['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['artist_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['release_year'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['genre'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="/albums/edit?id=<?php echo $album['id']; ?>">Edit</a>
                    <a href="/albums/delete?id=<?php echo $album['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this album?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>