<title>Business</title>
<?php
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update = $_GET['update'] ?? null;
    if($update == "details") {
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;

        if(!$hasVendor) {
            $sql = "INSERT INTO vendors (user_id, name, email, phone, address) VALUES ('$user[id]', '$name', '$email', '$phone', '$address')";
            $result = mysqli_query($conn, $sql);
            if($result) {
                $_SESSION['success'] = 'Business profile created successfully.';
            } else {
                $_SESSION['error'] = 'An error occurred while creating your business profile. Please try again.';
            }
        } else {
            $sql = "UPDATE vendors SET name = '$name', email = '$email', phone = '$phone', address = '$address' WHERE user_id = '$user[id]'";
            $result = mysqli_query($conn, $sql);
            if($result) {
                $_SESSION['success'] = 'Business profile updated successfully.';
            } else {
                $_SESSION['error'] = 'An error occurred while updating your business profile. Please try again.';
            }
        }
        $hasVendor = true;
    }
    if($update == "profilePicture") {
        $profilePicture = $_FILES['profile_picture'] ?? null;
        if($profilePicture) {
            $profile_picture = $_FILES['profile_picture']['name'];
            $tmp_name = $_FILES['profile_picture']['tmp_name'];
            $path = '../images/vendor_profile_picture/' . $profile_picture;
            move_uploaded_file($tmp_name, $path);

            $sql = "UPDATE vendors SET profile_picture = '$path' WHERE id = '$vendor[id]'";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = 'Profile picture updated';
                $vendorProfilePic = $path;
            } else {
                $_SESSION['error'] = 'Failed to update profile picture';
            }
        }
    }
}

?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';

        $vendorName = $vendor['name'] ?? 'N/A';
        $vendorProfilePic = $path ?? getVendorProfilePicture($vendor);
        $vendorEmail = $vendor['email'] ?? 'N/A';
        $vendorPhone = $vendor['phone'] ?? 'N/A';
        $vendorAddress = $vendor['address'] ?? 'N/A';
        ?>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Business Info
                    </div>
                    <div>
                        <a href="edit-business.php" class="btn btn-success">Edit</a>
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
                            <img src="<?php echo ($vendorProfilePic); ?>" alt="Profile Picture" class="img-thumbnail rounded-circle" style="width: 125px; height: 125px; object-fit: cover;"><br />
                            <?php
                            if($hasVendor) {
                            ?>
                            <button id="changeImageButton" class="btn btn-link mt-2" onclick="updateImage()">Change</button>
                            <form id="updateImageForm" action="business-info.php?update=profilePicture" method="POST" enctype="multipart/form-data" class="d-none">
                                <input type="file" name="profile_picture" id="profilePicture" onchange="updateImageForm()" accept="image/*">
                            </form>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-center">
                        <div class="col-md-4 col-form-label text-md-end fw-bolder">
                            Name
                        </div>

                        <div class="col-md-6">
                            <?php
                            echo $vendorName;
                            ?>
                        </div>

                        <div class="col-md-4 col-form-label text-md-end fw-bolder">
                            Email Address
                        </div>

                        <div class="col-md-6">
                            <?php
                            echo $vendorEmail;
                            ?>
                        </div>

                        <div class="col-md-4 col-form-label text-md-end fw-bolder">
                            Phone
                        </div>

                        <div class="col-md-6">
                            <?php
                            echo $vendorPhone;
                            ?>
                        </div>

                        <div class="col-md-4 col-form-label text-md-end fw-bolder">
                            Address
                        </div>

                        <div class="col-md-6">
                            <?php
                            echo $vendorAddress;
                            ?>
                        </div>
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