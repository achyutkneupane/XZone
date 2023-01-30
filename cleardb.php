<?php

include('db.php');

$query_disable_checks = 'SET foreign_key_checks = 0';
$result = mysqli_query($conn, $query_disable_checks);

$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_row($result)) {
    $sql = "DROP TABLE IF EXISTS $row[0]";
    $wiperesult = mysqli_query($conn, $sql);
    if(!$wiperesult) {
        echo "Error dropping table $row[0]: " . mysqli_error($conn);
    }
}

$query_enable_checks = 'SET foreign_key_checks = 1';
$result = mysqli_query($conn, $query_enable_checks);

if(!$result) {
    echo "Error enabling foreign key checks: " . mysqli_error($conn);
} else {
    echo "Database cleared successfully";
}