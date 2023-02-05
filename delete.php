<?php

include 'db.php';

// if request method post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // if delete button is clicked
    if (isset($_POST['delete'])) {
        // get id from form
        $id = $_POST['id'];
        $table = $_POST['table'];

        // delete from database
        $sql = "DELETE FROM $table WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        // if delete is successful

        if ($result) {
            $_SESSION['success'] = 'Booking deleted successfully!';
        } else {
            $_SESSION['error'] = 'Something went wrong!';
        }

        // redirect to bookings page
        echo '<meta http-equiv="refresh" content="0; URL=/bookings.php">';
        exit();
    }
}