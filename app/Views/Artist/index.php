<h2>Artist List</h2>

<table class="table">
<thead>
    <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Stage Name</th>
        <th>Bio</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($artists as $artist): ?>
        <tr>
            <td><?php echo htmlspecialchars($artist['id'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($artist['user_id'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($artist['stage_name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($artist['bio'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
                <a href="/artists/edit?id=<?php echo $artist['id']; ?>">Edit</a>
                <a href="/artists/delete?id=<?php echo $artist['id']; ?>" onclick="return confirm('Are you sure you want to delete this artist?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
