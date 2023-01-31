<title>XZone</title>
<?php
include 'header.php';

$searchTerm = $_GET['search'];
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
        AND
        (
            p.name LIKE '%$searchTerm%'
            OR p.user_id IN (SELECT id FROM users WHERE name LIKE '%$searchTerm%')
            OR p.user_id IN (SELECT user_id FROM vendors WHERE name LIKE '%$searchTerm%')
            OR p.user_id IN (SELECT user_id FROM vendors WHERE address LIKE '%$searchTerm%')
            OR category_id IN (SELECT id FROM categories WHERE name LIKE '%$searchTerm%')
        )
        ";
$pets = mysqli_query($conn, $sql);
?>
<div class="container my-3">
    <div class="row">
        <div class="offset-md-9 col-md-3">
            <!-- search bar -->
            <form action="search.php" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo $searchTerm; ?>" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
        <?php
        if(mysqli_num_rows($pets) == 0) {
            echo '<div class="alert alert-danger">No results found for <strong>'.$searchTerm.'</strong></div>';
        } else {
            echo '<div class="bg-white p-3 mb-4">Search results for <strong>'.$searchTerm.'</strong>:</div>';
            include 'products.php';
        }
        ?>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>