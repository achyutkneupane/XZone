<title>Pet Parks</title>
<?php
include '../header.php';
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
                        Pet Parks
                    </div>
                    <div>
                        <a href="add-petpark.php" class="btn btn-success">Add Pet Park</a>
                    </div>
                </div>

                <div class="card-body">
                    <?php
                    include '../alert.php';

                    $sql = "SELECT * FROM petpark";
                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0) {

                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Park Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Location</th>
                                <th scope="col">Latitude</th>
                                <th scope="col">Longitude</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>{$row['name']}</td>
                                    <td><img src='{$row['image']}' width='100' /></td>
                                    <td>{$row['location']}</td>
                                    <td>{$row['latitude']}</td>
                                    <td>{$row['longitude']}</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    } else {
                        echo "<div class='alert alert-warning'>No pet parks found.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include '../footer.php';
?>