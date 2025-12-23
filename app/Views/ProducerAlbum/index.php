<h1>My Productions</h1>

<?php if ($producer): ?>
    <a href="/producer/<?= $producer->id ?>/album/create">Produce a new album</a>
<?php endif; ?>

<?php if (empty($productions)): ?>
    <p>You have not produced any albums yet.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Artist</th>
                <th>Album</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productions as $index => $production): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($production['artist_name'] ?? 'Unknown') ?></td>
                    <td><?= htmlspecialchars($production['album_title'] ?? 'Unknown') ?></td>
                    <td><?= htmlspecialchars($production['created_at']) ?></td>
                    <td>
                        <a href="/producer/<?= $producer->id ?>/album/<?= $production['id'] ?>/delete"
                            onclick="return confirm('Are you sure you want to finish this production?');">
                            Finish
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>