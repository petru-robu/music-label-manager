<?php

require_once __DIR__ . '/../app/Database.php';

echo 'This is my test.php script!' . '<br />';

$pdo = Database::getConnection();

$sql = "SHOW TABLES";
$res = $pdo->query($sql);
$rows = $res->fetchAll(PDO::FETCH_NUM);

var_dump($rows);

echo 'Tables in my DB are: ' . '<br />';
foreach ($rows as $row)
{
    print_r($row);
    echo $row[0] . '<br />';
}

?>