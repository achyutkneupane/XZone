<title>Edit Profile</title>
<?php
include '../header.php';
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];
            if (empty($_POST['name'])) {
                $errors['name'] = 'Name is required';
            }
            if (empty($_POST['email'])) {
                $errors['email'] = 'Email is required';
            }
            if (empty($_POST['phone'])) {
                $errors['phone'] = 'Phone is required';
            }
            if (empty($_POST['password'])) {
                $errors['password'] = 'Password is required';
            }

            // if no errors
            if (empty($errors)) {
                // check password
                if ($_POST['password'] == $user['password']) {
                    // update user
                    $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sssi', $_POST['name'], $_POST['email'], $_POST['phone'], $user['id']);
                    $stmt->execute();
                    $stmt->close();

                    header('Location: profile.php');
                } else {
                    $_SESSION['error'] = 'Password is incorrect';
                }
            }
        }

        ?>
        <div class="col-md-9">
            <form class="card" action="edit-profile.php" method="POST">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Profile
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-12">
                            <?php
                            include '../alert.php';
                            ?>
                        </div>
                    </div>
                    <div class="row gy-3 mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" placeholder="Update your name" name="name" value="<?php echo $user['name']; ?>" required autocomplete="name" autofocus>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" placeholder="Update your email" name="email" value="<?php echo $user['email']; ?>" required autocomplete="email">
                        </div>
                    </div>

                    <div class="row gy-3 mb-3">
                        <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>

                        <div class="col-md-6">
                            <input id="phone" type="text" class="form-control" placeholder="Update your contact number" name="phone" value="<?php echo $user['phone']; ?>" required autocomplete="phone" minlength="10" maxlength="10">
                        </div>
                    </div>

                    <div class="row gy-3 mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                            <small class="form-text text-muted">
                                You must enter your password to edit profile.
                            </small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include '../footer.php';
?>