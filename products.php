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

        if (mysqli_num_rows($products) <= 0) {
        ?>

            <div class="col-md-12 border rounded bg-white p-3 text-center">
                No Products Found
            </div>
        <?php
        } else {
            while ($row = mysqli_fetch_assoc($products)) {
                $product_id = $row['product_id'];
                $image = $row['image'];
                $name = $row['product_name'];
                $category = $row['category_name'];
                $vendorName = getVendorNameById('products',$product_id);
                $price = $row['price'];
                echo "
                <div class='col-md-4'>
                    <div class='card'>
                        <div class='card-img-top-wrap'>
                            <img class='card-img-top' src='$image' alt='$name' height='250' style='object-fit: cover;' />
                        </div>
                        <div class='card-body'>
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
                            </div>
                        </div>
                        <div class='card-footer text-center'>
                            <a href='product.php?id=$product_id' class='btn btn-success btn-block w-50'>Go to Details</a>
                        </div>
                    </div>
                </div>
                ";
            }
        ?>

        <?php
        }
        ?>
    </div>
</div>