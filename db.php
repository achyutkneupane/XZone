<?php
session_start();

$db_host = "localhost";
$db_user = "achyut";
$db_password = "achyut";
$db_name = "petshop-php";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

include 'auth.php';

