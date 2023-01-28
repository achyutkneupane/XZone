<?php

$route = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
$hasVendor = false;
$vendor = null;
$domain = "http://".$_SERVER['HTTP_HOST'];

if (isset($user)) {
    if ($isVendor) {
        $sql = "SELECT * FROM vendors WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        $vendorRes = mysqli_fetch_assoc($result);

        if (!$vendorRes) {
            if ($route != 'edit-business.php') {
                // get domain
                $editBusiness = "$domain/dashboard/edit-business.php";
                $_SESSION['error'] = 'You have not created a business profile yet. Please <a href="'.$editBusiness.'">create one</a> to continue.';
            }
        } else {
            $hasVendor = true;
            $vendor = $vendorRes;
        }
    }
}
