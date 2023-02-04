<title>Product Details</title>
<?php
include 'header.php';

$id = $_GET['id'];

$sql = "SELECT
        p.id AS product_id,
        p.name AS product_name,
        p.description AS description,
        p.price AS price,
        p.image AS image,
        c.name AS category_name
        FROM products AS p
        INNER JOIN categories AS c ON p.category_id = c.id
        WHERE p.id = '$id'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
}

?>
<style>
    .product-image {
        box-shadow: 0px 0px 10px #777;
        border-radius: 10px;
        margin-bottom: 2em;
    }

    .product-name {
        font-size: 2em;
        margin-bottom: 0.5em;
    }

    .product-price {
        font-size: 1.5em;
        font-weight: bold;
        color: #4CAF50;
        margin-bottom: 0.5em;
    }

    .product-category {
        color: #777;
        margin-bottom: 1em;
    }

    .product-rating {
        color: #FDA50F;
    }

    .product-description {
        font-size: 1.2em;
        line-height: 1.5em;
        margin-bottom: 2em;
    }

    .booking-button {
        border-radius: 30px;
        padding: 0.5em 2em;
        font-size: 1.2em;
        font-weight: bold;
        background-color: #4CAF50;
        color: #fff;
        transition: all 0.3s ease;
    }

    .booking-button:hover {
        background-color: #3E8E41;
        cursor: pointer;
    }
</style>
<div class="container bg-white my-4 p-5 rounded-4">
    <div class="row gy-3 align-items-center">
        <div class="col-md-6">
            <img src="<?php echo $product['image']; ?>" class="img-fluid product-image my-auto" alt="Product Image">
        </div>
        <div class="col-md-6">
            <?php
            include 'alert.php';
            ?>
            <h1 class="product-name"><?php echo $product['product_name']; ?></h1>
            <p class="product-price">Nrs. <?php echo $product['price']; ?></p>
            <p class="product-category">
                <strong>Category:</strong> <?php echo $product['category_name']; ?>
            </p>
            <!-- added by -->
            <p class="product-category">
                <strong>Added by:</strong> <?php echo getVendorNameById('products',$product['product_id']); ?>
            </p>
            <p class="product-description">
                <?php echo $product['description']; ?>
            </p>
            <?php
            if(!$isAdmin && !$isVendor) {
            ?>
            <form action="bookings.php?action=book&product=<?php echo $product['product_id']; ?>" method="POST">
                <div class="input-group mb-3">
                    <span class="input-group-text bg-success text-white" id="basic-addon1">Quantity</span>
                    <input type="number" class="form-control" placeholder="1" aria-label="Quantity" aria-describedby="basic-addon1" min="0" name="quantity">
                </div>
                <input type="submit" class="btn btn-success booking-button" value="Book">
            </form>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>