<?php

include 'db.php';

unset($_SESSION['user']);
header('location: login.php');

?>