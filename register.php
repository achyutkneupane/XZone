<title>Register</title>
<?php
include 'header.php';

if (isset($_SESSION['user'])) {
    echo '<meta http-equiv="refresh" content="0; URL=/">';
}
?>

<?php

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // validate
    if(empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = 'All fields are required';
        echo '<meta http-equiv="refresh" content="0; URL=/register.php">';
        exit();
    }

    // check if email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = 'Email already exists';
        echo '<meta http-equiv="refresh" content="0; URL=/register.php">';
        exit();
    }

    // if email is in format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format';
        echo '<meta http-equiv="refresh" content="0; URL=/register.php">';
        exit();
    }

    // if password is more than 8 characters
    if (strlen($password) < 8) {
        $_SESSION['error'] = 'Password must be at least 8 characters';
        echo '<meta http-equiv="refresh" content="0; URL=/register.php">';
        exit();
    }

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

    if (!mysqli_query($conn, $sql)) {
        die("Error inserting data: " . mysqli_error($conn));
    } else {
        $_SESSION['success'] = 'User registered successfully';
        echo '<meta http-equiv="refresh" content="0; URL=/login.php">';
        exit();
    }
}

?>

<div class="container">
    <div class="row gy-3 mt-5">
        <div class="col-md-6 offset-md-3 mt-5">
            <?php
            include_once 'alert.php';
            ?>
            <div class="border mt-5 p-4 rounded-4 bg-success bg-opacity-75 text-white">
                <h1 class="text-uppercase text-center py-3">Register</h1>
                <hr />
                <form action="" method="POST" class="mt-4">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required />
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required />
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required />
                    </div>

                    <div class="form-group mb-3">
                        <input type="submit" name="register" value="Register" class="btn btn-primary" />
                    </div>

                    <p>Already have an account? <a href="login.php" class="">Login</a></p>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>