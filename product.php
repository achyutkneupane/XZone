<title>XZone</title>
<?php
include 'header.php';

// if post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "review") {
            $pet_id = $_GET['id'];
            $user_id = $user['id'];
            $rating = $_POST['rating'];
            $review = $_POST['review'];

            $sql = "INSERT INTO reviews (pet_id, user_id, rating, review) VALUES ('$pet_id', '$user_id', '$rating', '$review')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['success'] = 'Review added successfully!';
                echo '<meta http-equiv="refresh" content="0; URL=product.php?id=' . $pet_id . '" />';
                exit();
            } else {
                $_SESSION['error'] = 'Something went wrong!';
            }
        }
    }
}

$id = $_GET['id'];

$sql = "SELECT
        p.id AS pet_id,
        p.name AS pet_name,
        c.name AS category_name,
        p.price AS price,
        p.image AS image,
        p.quantity AS quantity,
        p.description AS description
        FROM pets AS p
        INNER JOIN categories AS c ON p.category_id = c.id
        WHERE p.id = '$id'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $pet = mysqli_fetch_assoc($result);
}

?>

<?php
$sql = "SELECT * FROM reviews WHERE pet_id = $id";
$reviewResult = mysqli_query($conn, $sql);
$reviewsCount = mysqli_num_rows($reviewResult);

$sql = "SELECT AVG(rating) AS rating FROM reviews WHERE pet_id = $id";
$result = mysqli_query($conn, $sql);
$rating = mysqli_fetch_assoc($result);
$rating = $rating['rating'] ? round($rating['rating'], 1, PHP_ROUND_HALF_DOWN) : 0;
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
                <strong>Added by:</strong> <?php echo getVendorNameByPetId($pet['pet_id']); ?>
            </p>
            <div class="product-rating">
                <!-- <i class="far fa-star"></i> for no rate -->
                <!-- <i class="fas fa-star"></i> for full rate -->
                <!-- <i class="fas fa-star-alt"></i> for half rate -->
                <?php
                for ($i = 0; $i < 5; $i++) {
                    if ($rating > $i) {
                        if ($rating > $i + 0.5) {
                            echo '<i class="fas fa-star"></i>';
                        } else {
                            echo '<i class="fas fa-star-half-alt"></i>';
                        }
                    } else {
                        echo '<i class="far fa-star"></i>';
                    }
                }
                ?>
            </div>
            <div class="mb-3 text-muted">
                <?php echo $reviewsCount; ?> Review<?php echo $reviewsCount > 1 ? 's' : ''; ?>
            </div>

            <p class="product-description">
                <?php echo $pet['description']; ?>
            </p>
            <?php
            if(!$isAdmin && !$isVendor) {
            ?>
            <form action="bookings.php?action=book&product=<?php echo $pet['pet_id']; ?>" method="POST">
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


    <style>
        .review-card {
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .review-title {
            font-weight: bold;
        }

        .review-rating {
            display: flex;
        }

        .review-rating i {
            color: #ffc107;
            font-size: 1.5em;
            margin-right: 5px;
        }

        #review-text {
            resize: none;
        }

        #review-rating {
            height: calc(2.25rem + 2px);
        }

        .row.gy-3 {
            margin-bottom: 2rem;
        }

        h3 {
            font-weight: bold;
            margin-bottom: 1rem;
        }

        form {
            background-color: #f9f9f9;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        }

        label {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        textarea.form-control {
            resize: vertical;
        }

        select.form-control {
            height: 3.125rem;
        }

        button[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: #fff;
            border-color: #4CAF50;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        button[type="submit"]:hover {
            background-color: #3E8E41;
            border-color: #3E8E41;
            cursor: pointer;
        }
    </style>
    <?php
    if(canReview($pet['pet_id'])) {
    ?>
    <div class="row gy-3 mt-5">
        <h3>Add a Review</h3>
        <form action="product.php?action=review&id=<?php echo $pet['pet_id']; ?>" method="POST">
            <div class="form-group mb-3">
                <label for="review-text">Review</label>
                <textarea class="form-control" id="review-text" rows="3" name="review" placeholder="Enter your review"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="review-rating">Rating</label>
                <select class="form-control" id="review-rating" name="rating">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <input type="submit" class="btn btn-success" value="Submit Review" />
        </form>
    </div>
    <?php
    }
    ?>

    <?php
    if (mysqli_num_rows($reviewResult) > 0) {
    ?>
        <div class="row gy-3 mt-5 justify-content-center">
            <h2>Product Reviews</h2>
            <?php
            while ($review = mysqli_fetch_assoc($reviewResult)) {
            ?>
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-title">
                                <p class="review-date"><?php echo date('d M, Y', strtotime($review['created_at'])); ?></p>
                            </div>
                            <div class="review-rating">
                                <?php
                                $rating = $review['rating'];
                                for ($i = 0; $i < 5; $i++) {
                                    if ($rating > $i) {
                                        if ($rating > $i + 0.5) {
                                            echo '<i class="fas fa-star"></i>';
                                        } else {
                                            echo '<i class="fas fa-star-half-alt"></i>';
                                        }
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>

                        </div>
                        <div class="review-body">
                            <div>
                                <?php echo $review['review']; ?>
                            </div>
                            <div class="text-muted">
                                -
                                <?php
                                $sql = "SELECT `name` FROM users WHERE id = " . $review['user_id'];
                                $userResult = mysqli_query($conn, $sql);
                                $user = mysqli_fetch_assoc($userResult);
                                echo $user['name'];
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
    }
    ?>
</div>
<?php
include 'footer.php';
?>