<h2>Artist List</h2>

<a href="/dashboard">Back to dashboard</a>

<table class="table" id="artistTable">
    <thead>
        <tr>
            <th onclick="sortArtistTable(0)">ID &#x25B2;&#x25BC;</th>
            <th onclick="sortArtistTable(1)">User ID &#x25B2;&#x25BC;</th>
            <th onclick="sortArtistTable(2)">Stage Name &#x25B2;&#x25BC;</th>
            <th onclick="sortArtistTable(3)">Bio &#x25B2;&#x25BC;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($artists as $artist): ?>
            <tr>
                <td><?php echo htmlspecialchars($artist['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($artist['user_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($artist['stage_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($artist['bio'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
let artistSortDirections = [true, true, true, true]; // ascending by default

function sortArtistTable(columnIndex) {
    const table = document.getElementById("artistTable");
    const tbody = table.tBodies[0];
    const rows = Array.from(tbody.rows);

    const ascending = artistSortDirections[columnIndex];
    rows.sort((a, b) => {
        let cellA = a.cells[columnIndex].innerText.toLowerCase();
        let cellB = b.cells[columnIndex].innerText.toLowerCase();

        // numeric sort for ID and User ID
        if ([0, 1].includes(columnIndex)) {
            cellA = parseInt(cellA) || 0;
            cellB = parseInt(cellB) || 0;
        }

        if (cellA < cellB) return ascending ? -1 : 1;
        if (cellA > cellB) return ascending ? 1 : -1;
        return 0;
    });

    rows.forEach(row => tbody.appendChild(row));

    artistSortDirections[columnIndex] = !ascending;
}
</script>
