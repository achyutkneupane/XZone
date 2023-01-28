<title>XZone</title>
<?php
include 'header.php';

$id = $_GET['id'];

$sql = "SELECT
        p.id AS pet_id,
        p.name AS pet_name,
        c.name AS category_name,
        p.price AS price,
        p.image AS image,
        p.quantity AS quantity,
        p.description AS description,
        v.name AS vendor_name
        FROM pets AS p
        INNER JOIN categories AS c ON p.category_id = c.id
        INNER JOIN vendors AS v ON p.vendor_id = v.id
        WHERE p.id = '$id'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $pet = mysqli_fetch_assoc($result);
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

<style>
    .review-card {
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .review-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .review-title {
        flex: 1;
    }

    .review-date {
        font-size: 12px;
        color: #777;
        margin-top: 5px;
    }

    .review-rating {
        font-size: 20px;
        margin-left: 10px;
    }

    .review-rating i {
        color: #ffc107;
    }

    form {
        margin-top: 20px;
    }

    form label {
        font-weight: 600;
    }

    form .form-control {
        border-radius: 10px;
    }


    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group-text {
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 10px 0 0 10px;
        padding: 10px 15px;
    }

    .form-control {
        border-radius: 0 10px 10px 0;
        border: 1px solid #ccc;
        padding: 10px 15px;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
<div class="container bg-white mt-4 p-5 rounded-4">
    <div class="row gy-3 align-items-center">
        <div class="col-md-6">
            <img src="<?php echo $pet['image']; ?>" class="img-fluid product-image my-auto" alt="Product Image">
        </div>
        <div class="col-md-6">
            <?php
            include 'alert.php';
            ?>
            <h1 class="product-name"><?php echo $pet['pet_name']; ?></h1>
            <p class="product-price">Nrs. <?php echo $pet['price']; ?></p>
            <p class="product-category">
                <strong>Category:</strong> <?php echo $pet['category_name']; ?>
            </p>
            <!-- added by -->
            <p class="product-category">
                <strong>Added by:</strong> <?php echo $pet['vendor_name']; ?>
            </p>
            <div class="product-rating">
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <!-- <i class="fas fa-star-half-alt"></i> -->
            </div>
            <div class="mb-3 text-muted">
                0 reviews
            </div>

            <p class="product-description">
                <?php echo $pet['description']; ?>
            </p>
            <form action="bookings.php?action=book&product=<?php echo $pet['pet_id']; ?>" method="POST">
                <div class="input-group mb-3">
                    <span class="input-group-text bg-success text-white" id="basic-addon1">Quantity</span>
                    <input type="number" class="form-control" placeholder="1" aria-label="Quantity" aria-describedby="basic-addon1" min="0" name="quantity">
                </div>
                <input type="submit" class="btn btn-success booking-button" value="Book">
            </form>
        </div>
    </div>


    <!-- <div class="row gy-3 mt-5">
        <h2>Product Reviews</h2>
        <div class="col-md-6">
            <div class="review-card">
                <div class="review-header">
                    <div class="review-title">
                        <p class="review-date">January 1, 2022</p>
                    </div>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="review-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor,
                        magna at iaculis suscipit, ipsum nibh euismod augue, ut euismod enim
                        velit vel velit.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="review-card">
                <div class="review-header">
                    <div class="review-title">
                        <p class="review-date">January 2, 2022</p>
                    </div>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                </div>
                <div class="review-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor,
                        magna at iaculis suscipit, ipsum nibh euismod augue, ut euismod enim
                        velit vel velit.
                    </p>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div class="row gy-3 mt-5">
        <h3>Add a Review</h3>
        <form>
            <div class="form-group mb-3">
                <label for="review-text">Review</label>
                <textarea class="form-control" id="review-text" rows="3" placeholder="Enter your review"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="review-rating">Rating</label>
                <select class="form-control" id="review-rating">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Submit Review</button>
        </form>
    </div> -->
</div>
<?php
include 'footer.php';
?>