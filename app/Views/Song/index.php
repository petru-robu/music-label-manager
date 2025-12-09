<h2>Song List</h2>

<table class="table">
<thead>
    <tr>
        <th>Title</th>
        <th>Artist</th>
        <th>Year</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($songs as $song): ?>
        <tr>
            <td><?php echo htmlspecialchars($song['title'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($song['artist'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($song['year'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
