<?php

include 'db.php';

unset($_SESSION['user']);
echo '<meta http-equiv="refresh" content="0; URL=/login.php">';
exit();

?>