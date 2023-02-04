<title>Login</title>
<?php
include 'header.php';

if (isset($_SESSION['user'])) {
    echo '<meta http-equiv="refresh" content="0; URL=/">';
}
?>

<?php

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['user'] = $row['id'];
        echo '<meta http-equiv="refresh" content="0; URL=/">';
        exit();
    } else {
        $_SESSION['error'] = 'Invalid email or password';
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
                <h1 class="text-uppercase text-center py-3">Login</h1>
                <hr />
                <form action="" method="POST" class="mt-4">
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required />
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required />
                    </div>

                    <div class="form-group mb-3">
                        <input type="submit" name="login" value="Login" class="btn btn-primary" />
                    </div>
                </form>

                <p>Don't have an account? <a href="register.php" class="">Register</a></p>

            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>