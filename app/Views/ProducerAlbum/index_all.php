<h1>All Productions</h1>

<?php if (empty($productions)): ?>
    <p>No productions found.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Producer</th>
                <th>Artist</th>
                <th>Album</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productions as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($p['studio_name']) ?></td>
                    <td><?= htmlspecialchars($p['artist_name']) ?></td>
                    <td><?= htmlspecialchars($p['album_title']) ?></td>
                    <td><?= htmlspecialchars($p['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>