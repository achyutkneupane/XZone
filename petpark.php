<title>XZone</title>
<?php
include 'header.php';
$parkCount = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['address'])) {
        $address = $_POST['address'];

        $sql = "SELECT *
            FROM petpark
            WHERE name LIKE '%$address%'
            OR location LIKE '%$address%'
            OR latitude LIKE '%$address%'
            OR longitude LIKE '%$address%'";
        $result = mysqli_query($conn, $sql);
        $parkCount = mysqli_num_rows($result);
    }
}
?>
<div class="container my-5 card p-5 bg-white">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center text-uppercase">
            <h1 class="text-success">Find Nearby Pet Park</h1>
        </div>
        <form class="col-md-7" action="petpark.php" method="POST">
            <div class="form-group mb-3">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" placeholder="Enter your address" required />
            </div>
            <div class="form-group mb-3">
                <input type="submit" name="submit" id="submit" class="btn" value="Search" />
            </div>
        </form>
    </div>
    <?php
    if ($parkCount != "" && $parkCount > 0) {
    ?>
        <div class="row mb-4 justify-content-center">
            <div class="col-md-7">
                <div class="alert alert-success">
                    Search Result for <strong><?php echo $address; ?></strong>
                </div>
                <div class="row">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                    <div class='col-md-4 border p-2 rounded'>
                        <h3 class='text-success'>{$row['name']}</h3>
                        <img src='{$row['image']}' class='img-fluid' />
                        <p>{$row['location']}</p>
                        <p>Map link: <a href='https://www.google.com/maps/search/?api=1&query={$row['latitude']},{$row['longitude']}' target='_blank'>{$row['latitude']},{$row['longitude']}</a></p>
                    </div>
                    ";
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    } else {
        if ($parkCount != "") {
            echo "
            <div class='row mb-4 justify-content-center'>
                <div class='col-md-7'>
                    <div class='alert alert-danger'>
                        No result found for <strong>{$address}</strong>
                    </div>
                </div>
            </div>
            ";
        }
    }
    ?>
</div>
<?php
include 'footer.php';
?>