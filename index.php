<title>XZone</title>
<?php
include 'header.php';
?>
<div class="container mt-3">
    <div class="offset-md-9 col-md-3">
        <!-- search bar -->
        <form action="search.php" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </div>
        </form>
    </div>
    <?php
    include 'products.php';
    ?>
</div>
<?php
include 'footer.php';
?>