<?php

include('db.php');

$sql = "DROP TABLE IF EXISTS `ratings`; ";
$sql .= "DROP TABLE IF EXISTS `pets`; ";
$sql .= "DROP TABLE IF EXISTS `vendors`; ";
$sql .= "DROP TABLE IF EXISTS `categories`; ";
$sql .= "DROP TABLE IF EXISTS `users`; ";

if (!mysqli_query($conn, $sql)) {
    die("Error dropping tables: " . mysqli_error($conn));
} else {
    echo "Tables dropped successfully";
}