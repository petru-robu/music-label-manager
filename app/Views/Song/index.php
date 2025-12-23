<h2>Song List</h2>
<a href="/dashboard">Back to dashboard</a>
<table class="table" id="songTable">
    <thead>
        <tr>
            <th onclick="sortTable(0)">Title <span class="sort-arrows">&#x25B2;&#x25BC;</span></th>
            <th onclick="sortTable(1)">Artist <span class="sort-arrows">&#x25B2;&#x25BC;</span></th>
            <th onclick="sortTable(2)">Year <span class="sort-arrows">&#x25B2;&#x25BC;</span></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($songs as $song): ?>
            <tr>
                <td><?php echo htmlspecialchars($song['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($song['artist'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($song['album_year'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    let sortDirections = [true, true, true]; // true = ascending, false = descending

    function sortTable(columnIndex) {
        const table = document.getElementById("songTable");
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.rows);

        const ascending = sortDirections[columnIndex];
        rows.sort((a, b) => {
            let cellA = a.cells[columnIndex].innerText.toLowerCase();
            let cellB = b.cells[columnIndex].innerText.toLowerCase();

            // Convert to number if sorting the Year column
            if (columnIndex === 2) {
                cellA = parseInt(cellA) || 0;
                cellB = parseInt(cellB) || 0;
            }

            if (cellA < cellB) return ascending ? -1 : 1;
            if (cellA > cellB) return ascending ? 1 : -1;
            return 0;
        });

        // Append sorted rows
        rows.forEach(row => tbody.appendChild(row));

        // Toggle sort direction for next click
        sortDirections[columnIndex] = !ascending;
    }
</script>