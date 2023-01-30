<?php
// error_reporting(0);

include 'db.php';
include 'auth.php';

include 'var.php';
include 'func.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .card {
            background-color: #f3f3f3;
            border: none;
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header,
        .card-footer {
            background-color: #4CAF50;
            color: #F5F5F5;
            font-size: 1.2em;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .card-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #4CAF50;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .card-text {
            font-size: 1.2em;
            color: #757575;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-img-bottom {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .card .btn {
            border-radius: 0;
            border: none;
            background-color: #f5f5f5;
            color: #4CAF50;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 5px;
        }

        .card .btn:hover {
            background-color: #0E5032;
            color: #F5F5F5;
        }
    </style>
</head>

<body style="background-color: #f3f3f3; color: #000; margin: 0; padding: 0;">
    <?php
    include 'navbar.php';
    ?>