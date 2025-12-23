<h2>Artist List</h2>

<a href="/dashboard">Back to dashboard</a>

<table class="table" id="artistTable">
    <thead>
        <tr>
            <th>Stage Name</th>
            <th>Bio</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($artists as $artist): ?>
            <tr>
                <td><?php echo htmlspecialchars($artist['stage_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($artist['bio'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>