<?php

include 'db.php';

unset($_SESSION['user']);
unset($_SESSION['success']);
unset($_SESSION['error']);
echo '<meta http-equiv="refresh" content="0; URL=/login.php">';
exit();

?>