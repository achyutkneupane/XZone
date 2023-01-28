<title>Profile</title>
<?php
include '../header.php';
$profilePic = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profile_picture = $_FILES['profile_picture']['name'];
    $tmp_name = $_FILES['profile_picture']['tmp_name'];
    $path = '../images/profile_picture/' . $profile_picture;
    move_uploaded_file($tmp_name, $path);

    $user_id = $_SESSION['user'];
    $sql = "UPDATE users SET profile_picture = '$path' WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Profile picture updated';
        $profilePic = $path;
    } else {
        $_SESSION['error'] = 'Failed to update profile picture';
    }
}
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';
        ?>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Profile
                    </div>
                    <div>
                        <a href="edit-profile.php" class="btn btn-success">Edit</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row gy-3 mb-3 align-items-center">
                        <div class="col-md-12">
                            <?php
                                include '../alert.php';
                            ?>
                        </div>
                        <div class="col-md-4 col-form-label text-md-end fw-bolder">
                            Profile Picture
                        </div>

                        <div class="col-md-6">
                            <img src="<?php echo($profilePic ?? getProfilePicture()); ?>" alt="Profile Picture" class="img-thumbnail rounded-circle" style="width: 125px; height: 125px; object-fit: cover;"><br />
                            <button id="changeImageButton" class="btn btn-link" onclick="updateImage()">Change</button>
                            <form id="updateImageForm" action="profile.php" method="POST" enctype="multipart/form-data" class="d-none">
                                <input type="file" name="profile_picture" id="profilePicture" onchange="updateImageForm()" accept="image/*">
                            </form>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-center">
                        <div class="col-md-4 col-form-label text-md-end fw-bolder">
                            Name
                        </div>

                        <div class="col-md-6">
                            <?php
                            if (isset($user['name'])) {
                                echo $user['name'];
                            } else {
                                echo '<span class="text-muted">N/A</span>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4 col-form-label text-md-end fw-bolder">
                            Email Address
                        </div>

                        <div class="col-md-6">
                            <?php
                            if (isset($user['email'])) {
                                echo $user['email'];
                            } else {
                                echo '<span class="text-muted">N/A</span>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4 col-form-label text-md-end fw-bolder">
                            Phone
                        </div>

                        <div class="col-md-6">
                            <?php
                            if (isset($user['phone'])) {
                                echo $user['phone'];
                            } else {
                                echo '<span class="text-muted">N/A</span>';
                            }
                            ?>
                        </div>

                        <div class="col-md-4 col-form-label text-md-end fw-bolder">
                            Role
                        </div>

                        <div class="col-md-6">
                            <?php
                            if (isset($user['role'])) {
                                echo ucwords($user['role']);
                            } else {
                                echo '<span class="text-muted">N/A</span>';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateImage() {
            document.getElementById('profilePicture').click();
        }

        function updateImageForm() {
            document.getElementById('updateImageForm').submit();
        }
    </script>
    <?php
    include '../footer.php';
    ?>