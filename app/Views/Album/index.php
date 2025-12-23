<h2>Album List</h2>
<a href="/dashboard">Back to dashboard</a>

<table class="table" id="albumTable">
    <thead>
        <tr>
            <th onclick="sortAlbumTable(0)">
                Artist <span class="sort-arrows">&#x25B2;&#x25BC;</span>
            </th>
            <th onclick="sortAlbumTable(1)">
                Title <span class="sort-arrows">&#x25B2;&#x25BC;</span>
            </th>
            <th onclick="sortAlbumTable(2)">
                Released <span class="sort-arrows">&#x25B2;&#x25BC;</span>
            </th>
            <th onclick="sortAlbumTable(3)">
                Genre <span class="sort-arrows">&#x25B2;&#x25BC;</span>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($albums as $album): ?>
            <tr>
                <td><?php echo htmlspecialchars($album['artist_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['release_year'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($album['genre'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    let albumSortDirections = [true, true, true, true]; // one per column

    function sortAlbumTable(columnIndex) {
        const table = document.getElementById("albumTable");
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.rows);

        const ascending = albumSortDirections[columnIndex];

        rows.sort((a, b) => {
            let cellA = a.cells[columnIndex].innerText.trim();
            let cellB = b.cells[columnIndex].innerText.trim();

            // numeric sort for Release Year column
            if (columnIndex === 2) {
                cellA = parseInt(cellA, 10) || 0;
                cellB = parseInt(cellB, 10) || 0;
            } else {
                cellA = cellA.toLowerCase();
                cellB = cellB.toLowerCase();
            }

            if (cellA < cellB) return ascending ? -1 : 1;
            if (cellA > cellB) return ascending ? 1 : -1;
            return 0;
        });

        rows.forEach(row => tbody.appendChild(row));
        albumSortDirections[columnIndex] = !ascending;
    }
</script>