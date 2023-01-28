<?php

function getRole()
{
    if ($GLOBALS['user']['role'] == 'admin') {
        return 'Admin';
    } else if ($GLOBALS['user']['role'] == 'vendor') {
        return 'Pet Shop Owner';
    } else {
        return 'User';
    }
}

function getProfilePicture()
{
    $avatar = 'https://ui-avatars.com/api/?bold=true&color=198754&name=' . $GLOBALS['user']['name'];
    if($GLOBALS['user']['profile_picture'] == null) {
        return $avatar;
    } else {
        return $GLOBALS['user']['profile_picture'];
    }
}

function getVendorProfilePicture($vendor)
{
    $avatar = 'https://ui-avatars.com/api/?bold=true&color=198754&name=';
    if($vendor == null) {
        return $avatar.'Not+Available';
    } else {
        return $vendor['profile_picture'];
    }
}

function slugify($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    $text = preg_replace('~[^-\w]+~', '', $text);

    $text = trim($text, '-');

    $text = preg_replace('~-+~', '-', $text);

    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}
