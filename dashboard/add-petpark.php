<title>Add Pet Park</title>
<?php
include '../header.php';

// if post request
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get the form data
    $park_name = $_POST['park_name'];
    $park_location = $_POST['park_location'];
    $park_lat = $_POST['park_lat'];
    $park_long = $_POST['park_long'];
    $park_image = $_FILES['park_image']['name'];

    // get the image name
    $tmp_name = $_FILES['park_image']['tmp_name'];
    $path = '../images/petpark/' . $park_image;
    move_uploaded_file($tmp_name, $path);

    $sql = "INSERT INTO petpark (name, image, location, latitude, longitude) VALUES ('$park_name', '$path', '$park_location', '$park_lat', '$park_long')";
    if(mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Pet Park added';
        echo '<meta http-equiv="refresh" content="0; URL=petparks.php">';
        exit();
    } else {
        $_SESSION['error'] = 'Failed to add pet park';
    }
}
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';
        ?>
        <div class="col-md-9">
            <form action="add-petpark.php" method="POST" class="card" enctype="multipart/form-data">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Add Pet Park
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </div>

                <div class="card-body">
                    <?php
                    include '../alert.php';
                    ?>
                    <div class="mb-3">
                        <label for="park_name" class="col-form-label">Park Name</label>
                        <input type="text" class="form-control" id="park_name" name="park_name" placeholder="Enter the park name" required />
                    </div>
                    <div class="mb-3">
                        <label for="park_image" class="col-form-label">Park Image</label>
                        <input type="file" class="form-control" id="park_image" name="park_image" required />
                    </div>
                    <div class="mb-3">
                        <label for="park_location" class="col-form-label">Location Description</label>
                        <textarea name="park_location" id="park_location" class="form-control" placeholder="Enter the location description" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="park_lat" class="col-form-label">Latitude</label>
                        <input type="number" class="form-control" id="park_lat" name="park_lat" placeholder="Enter the latitude" required step="0.0000001" />
                    </div>
                    <div class="mb-3">
                        <label for="park_long" class="col-form-label">Longitude</label>
                        <input type="number" class="form-control" id="park_long" name="park_long" placeholder="Enter the longitude" required step="0.0000001" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include '../footer.php';
?>