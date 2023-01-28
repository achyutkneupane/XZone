<style>
    .card-img-top-wrap {
        position: relative;
    }

    .card-body {
        padding: 1.25rem;
    }

    .card-title {
        font-size: 1.5em;
        font-weight: 600;
        color: #4CAF50;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
    }

    .card-text {
        font-size: 1.2em;
        color: #757575;
        margin-bottom: 1.25rem;
    }

    .card-text .text-muted {
        color: #9E9E9E;
        font-weight: 400;
    }

    .rating {
        font-size: 1.2em;
        color: #FFC107;
        margin-bottom: 1.25rem;
    }

    .out-of-stock {
        font-size: 1.2em;
        color: #F44336;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
</style>
<div class="container">
    <div class="row gy-3 justify-content-center">
        <?php

        $sql = "SELECT
                p.id AS pet_id,
                p.name AS pet_name,
                c.name AS category_name,
                p.price AS price,
                p.image AS image,
                p.quantity AS quantity,
                v.name AS vendor_name
                FROM pets AS p
                INNER JOIN categories AS c ON p.category_id = c.id
                INNER JOIN vendors AS v ON p.vendor_id = v.id
                WHERE p.approved_at IS NOT NULL
            ";

        $pets = mysqli_query($conn, $sql);        

        if (mysqli_num_rows($pets) <= 0) {
        ?>

            <div class="col-md-12 border rounded bg-white p-3 text-center">
                No Pets Found
            </div>

        <?php
        } else {
            while ($row = mysqli_fetch_assoc($pets)) {
                $pet_id = $row['pet_id'];
                $image = $row['image'];
                $name = $row['pet_name'];
                $category = $row['category_name'];
                $vendorName = $row['vendor_name'];
                $price = $row['price'];
                if($row['quantity'] > 0)
                    $quantity = $row['quantity'];
                else
                    $quantity = 0;
                $outOfStock = $quantity <= 0 ? true : false;
                echo "
                <div class='col-md-4'>
                    <div class='card'>
                        <div class='card-img-top-wrap'>
                            <img class='card-img-top' src='$image' alt='$name'>
                        </div>
                        <div class='card-body'>
                            ";
                            if($outOfStock)
                                echo "<div class='out-of-stock'>Out of Stock</div>";
                        echo "
                            <h4 class='card-title'>
                                $name
                            </h4>
                            <div class='card-text fs-6'>
                                Category: <span class='text-muted fw-bold'>$category</span>
                                <br/>
                                Added By: <span class='text-muted fw-bold'>$vendorName</span>
                            </div>
                            <div class='d-flex justify-content-between align-items-center'>
                                <div class='card-text fs-6'>
                                    Price:
                                    <span class='text-muted fw-bold'>
                                        Nrs. $price
                                    </span>
                                </div>
                                <div class='rating fs-6'>
                                    <i class='far fa-star'></i>
                                    <i class='far fa-star'></i>
                                    <i class='far fa-star'></i>
                                    <i class='far fa-star'></i>
                                    <i class='far fa-star'></i>
                                    <span class='text-muted'>(0)</span>
                                </div>
                            </div>
                        </div>
                        <div class='card-footer text-center'>
                            <a href='product.php?id=$pet_id' class='btn btn-success btn-block w-50'>Go to Details</a>
                        </div>
                    </div>
                </div>
                ";
            }
        }

        ?>
    </div>
</div>