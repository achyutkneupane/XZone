<title>Edit Profile</title>
<?php
include '../header.php';
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_GET['type']) && $_GET['type'] == "business") {
                $hasBusiness = $_POST['has_business'];
                $sql = "UPDATE users SET has_business = $hasBusiness WHERE id = $user[id]";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $_SESSION['success'] = "Business status updated successfully";
                    if($hasBusiness) echo '<meta http-equiv="refresh" content="0; URL=business-info.php "/>';
                } else {
                    $_SESSION['error'] = "Business status update failed";
                }
            }

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
                    exit();
                } else {
                    $_SESSION['error'] = 'Password is incorrect';
                }
            }
        }
        ?>
        <div class="col-md-9">
            <?php
            include '../alert.php';
            ?>
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

            <form class="card" action="edit-profile.php?type=business" method="POST">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Business
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>

                <div class="card-body">
                    <input type="hidden" name="has_business" value="0">
                    <div class="form-group">
                        <input type="checkbox" name="has_business" value="1" <?php echo $user['has_business'] ? 'checked' : ''; ?>>
                        <label for="has_business">I have a business</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include '../footer.php';
?>