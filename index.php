<title>XZone</title>
<?php
include 'header.php';

$sql = "SELECT
                p.id AS pet_id,
                p.name AS pet_name,
                c.name AS category_name,
                p.price AS price,
                p.image AS image,
                p.quantity AS quantity,
                (SELECT COUNT(*) FROM reviews WHERE pet_id = p.id) AS review_count
                FROM pets AS p
                INNER JOIN categories AS c ON p.category_id = c.id
                WHERE p.approved_at IS NOT NULL
            ";

$pets = mysqli_query($conn, $sql);

$sql = "SELECT
        p.id AS product_id,
        p.name AS product_name,
        p.price AS price,
        p.image AS image,
        c.name AS category_name
        FROM products AS p
        INNER JOIN categories AS c ON p.category_id = c.id
        ORDER BY p.created_at DESC";

$products = mysqli_query($conn, $sql);

?>
<div class="container my-3">
    <div class="row">
        <div class="offset-md-9 col-md-3">
            <form action="search.php" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container mb-3">
    <div class="row">
        <div class="col-md-12 text-center text-uppercase">
            <h1 class="text-success">Pets</h1>
        </div>
    </div>
</div>
<?php
include 'pets.php';
?>
<div class="container my-3">
    <div class="row">
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
<div class="container mb-3">
    <div class="row">
        <div class="col-md-12 text-center text-uppercase">
            <h1 class="text-success">Products</h1>
        </div>
    </div>
</div>
<?php
include 'products.php';
?>
<div class="mb-5"></div>
<?php
include 'footer.php';
?>