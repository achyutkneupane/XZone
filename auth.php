<?php

$isAdmin = false;
$isVendor = false;

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
    $sql = "SELECT * FROM users WHERE id = '$user_id'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $isAdmin = $user['role'] == 'admin';
        $isVendor = $user['has_business'];
    }
}
