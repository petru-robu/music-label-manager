<h2>Album List</h2>
<a href="/dashboard">Back to dashboard</a>

<table class="table" id="albumTable">
    <thead>
        <tr>
            <th onclick="sortAlbumTable(0)">ID &#x25B2;&#x25BC;</th>
            <th onclick="sortAlbumTable(1)">Artist &#x25B2;&#x25BC;</th>
            <th onclick="sortAlbumTable(2)">Title &#x25B2;&#x25BC;</th>
            <th onclick="sortAlbumTable(3)">Release Year &#x25B2;&#x25BC;</th>
            <th onclick="sortAlbumTable(4)">Genre &#x25B2;&#x25BC;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($albums as $album): ?>
            <tr>
                <td><?php echo htmlspecialchars($album['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['artist_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['release_year'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['genre'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    let albumSortDirections = [true, true, true, true, true]; // initial ascending for each column

    function sortAlbumTable(columnIndex) {
        const table = document.getElementById("albumTable");
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.rows);

        const ascending = albumSortDirections[columnIndex];
        rows.sort((a, b) => {
            let cellA = a.cells[columnIndex].innerText.toLowerCase();
            let cellB = b.cells[columnIndex].innerText.toLowerCase();

            // numeric sort for ID and Release Year only
            if ([0, 3].includes(columnIndex)) {
                cellA = parseInt(cellA) || 0;
                cellB = parseInt(cellB) || 0;
            }

            if (cellA < cellB) return ascending ? -1 : 1;
            if (cellA > cellB) return ascending ? 1 : -1;
            return 0;
        });

        rows.forEach(row => tbody.appendChild(row));

        albumSortDirections[columnIndex] = !ascending;
    }
</script>
