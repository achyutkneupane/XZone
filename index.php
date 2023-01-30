<title>XZone</title>
<?php
include 'header.php';
?>
<div class="container my-3">
    <div class="row">
        <div class="offset-md-9 col-md-3">
            <!-- search bar -->
            <form action="search.php" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="d-flex justify-content-between border rounded bg-success align-items-center p-3 text-white">
                    <div>
                        Book your pet for the <strong>Pet Park</strong>
                    </div>
                    <div>
                        <a href="petpark.php" class="btn btn-light">Book Now</a>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php
    include 'products.php';
    ?>
<?php
include 'footer.php';
?>