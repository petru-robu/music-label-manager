<?php
// use maantje charting library (generates svg's)
require_once __DIR__ . '/../../../vendor/autoload.php';
use Maantje\Charts\Chart;
use Maantje\Charts\Bar\Bar;
use Maantje\Charts\Bar\Bars;
use Maantje\Charts\Line\Line;
use Maantje\Charts\Line\Lines;
?>

<h2>Website Analytics</h2>

<a href="/dashboard">Back to dashboard</a> <br/>
<a href="/admin/analytics/purge/30">Delete analytical data older than 30 days</a> <br/>
<a href="/admin/analytics/purge/0">Reset analytical data</a>

<!-- bar chart for visited pages -->
<h3>Top visited pages: </h3>
<?php
// take top 5 pages only
$topPagesLimited = array_slice($topPages, 0, 5);
$bars = [];
foreach ($topPagesLimited as $row) {
    $value = is_numeric($row['views']) ? (float) $row['views'] : 0;
    $bars[] = new Bar(
        name: $row['page'],
        value: $value
    );
}
$chart = new Chart(
    series: [
        new Bars(
            bars: $bars,
        ),
    ],
    width: 750,
    height: 300
);
echo $chart->render();
?>

<!-- line chart for views per day -->
<h3>Views per day: </h3>
<?php
$points = [[0, 2], [1, 3]];
$x = 2;
foreach ($viewsPerDay as $row) {
    $y = is_numeric($row['views']) ? (float) $row['views'] : 0;
    array_push($points, [$x, $y]);
    $x += 1;
}
$chart = new Chart(
    series: [
        new Lines(
            lines: [
                new Line(points: $points, color: 'blue')
            ]
        ),
    ],
    width: 750,
    height: 300
);
echo $chart->render();
?>

<!-- line chart for unique visitors per day -->
<h3>Unique visitors per day: </h3>
<?php
$points = [[0, 0], [1, 1]];
$x = 2;
foreach ($viewsPerDay as $row) {
    $y = is_numeric($totals['unique_visitors']) ? (float) $totals['unique_visitors'] : 0;
    array_push($points, [$x, $y]);
    $x += 1;
}
$chart = new Chart(
    series: [
        new Lines(
            lines: [
                new Line(points: $points, color: 'purple')
            ]
        ),
    ],
    width: 750,
    height: 300
);

echo $chart->render();
?>

<!-- analytics data displayed in tables -->
<h3>Totals</h3>
<table class="table">
    <thead>
        <tr>
            <th>Total Views</th>
            <th>Unique Visitors</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo htmlspecialchars($totals['total_views'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($totals['unique_visitors'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </tbody>
</table>

<h3>Views Per Day (Last 14 Days)</h3>
<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Views</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($viewsPerDay as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['day'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['views'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Top Pages</h3>
<table class="table">
    <thead>
        <tr>
            <th>Page</th>
            <th>Views</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($topPages as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['page'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['views'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>