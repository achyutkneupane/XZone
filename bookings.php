<title>My Bookings</title>
<?php
include 'header.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == "book") {
        if (isset($_GET['pet'])) {
            $product_id = isset($_GET['pet']) ? $_GET['pet'] : '';
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';

            // check if product exists
            $sql = "SELECT * FROM pets WHERE id = $product_id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $product = mysqli_fetch_assoc($result);
                // check if quantity is available
                if ($product['quantity'] >= $quantity) {
                    // check if user has already booked the product
                    $sql = "SELECT * FROM bookings WHERE user_id = $user[id] AND pet_id = $product_id";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $booking = mysqli_fetch_assoc($result);
                        // update booking
                        $sql = "UPDATE bookings SET quantity = $quantity, unit_price = $booking[unit_price] WHERE id = $booking[id]";
                        if (mysqli_query($conn, $sql)) {
                            $_SESSION['success'] = 'Booking updated successfully';
                        } else {
                            $_SESSION['error'] = 'Booking update failed';
                        }
                    } else {
                        // insert booking
                        $sql = "INSERT INTO bookings (user_id, pet_id, quantity, unit_price) VALUES ($user[id], $product_id, $quantity, $product[price])";
                        if (mysqli_query($conn, $sql)) {
                            $_SESSION['success'] = 'Booking added successfully';
                        } else {
                            $_SESSION['error'] = 'Booking add failed';
                        }
                    }
                } else {
                    $_SESSION['error'] = 'Quantity not sufficient';
                }
            } else {
                $_SESSION['error'] = 'Product not found';
            }
        } else if (isset($_GET['product'])) {
            $product_id = isset($_GET['product']) ? $_GET['product'] : '';
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';

            // check if product exists
            $sql = "SELECT * FROM products WHERE id = $product_id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $product = mysqli_fetch_assoc($result);
                $sql = "INSERT INTO product_bookings (user_id, product_id, quantity, unit_price) VALUES ($user[id], $product_id, $quantity, $product[price])";
                if (mysqli_query($conn, $sql)) {
                    $_SESSION['success'] = 'Booking added successfully';
                } else {
                    $_SESSION['error'] = 'Booking add failed';
                }
            } else {
                $_SESSION['error'] = 'Product not found';
            }
        } else if (isset($_GET['service'])) {
            $petName = isset($_POST['petName']) ? $_POST['petName'] : '';
            $service = isset($_POST['service']) ? $_POST['service'] : '';
            $petSize = isset($_POST['petSize']) ? $_POST['petSize'] : '';
            $date = isset($_POST['date']) ? $_POST['date'] : '';
            $time = isset($_POST['time']) ? $_POST['time'] : '';
            $price = 0;

            if ($petSize == "small") {
                $price = 200;
            } else if ($petSize == "medium") {
                $price = 350;
            } else if ($petSize == "large") {
                $price = 500;
            }

            $sql = "INSERT INTO services (user_id, pet_name, service, pet_size, booked_for, created_at, price) VALUES ($user[id], '$petName', '$service', '$petSize', '$date $time', NOW(), $price)";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = 'Booking added successfully';
            } else {
                $_SESSION['error'] = 'Booking add failed';
            }
        }
    }
}

if (isset($_GET['payment'])) {
    $status = $_GET['payment'];
    if (isset($_GET['amount'])) {
        $amount = $_GET['amount'];

        if ($status == 'success') {
            $refId = $_GET['refId'];
            $oid = $_GET['oid'];
            
            $petIds = [];
            $productIds = [];
            $serviceIds = [];

            $bookingIds = explode('_', $oid);

            foreach ($bookingIds as $bookingId) {
                $bookingLoopIds = explode('-', $bookingId);
                if ($bookingLoopIds[0] == 'pet') {
                    $petIds = array_slice($bookingLoopIds, 1);
                } elseif ($bookingLoopIds[0] == 'product') {
                    $productIds = array_slice($bookingLoopIds, 1);
                } elseif ($bookingLoopIds[0] == 'service') {
                    $serviceIds = array_slice($bookingLoopIds, 1);
                }
            }
            

            $sql = "INSERT INTO orders
                    (`paid_at`, `esewa_reference`)
                    VALUE (NOW(), '$refId')";
            $result = mysqli_query($conn, $sql);

            $orderId = "SELECT LAST_INSERT_ID()";
            $result = mysqli_query($conn, $orderId);
            $orderId = mysqli_fetch_assoc($result)['LAST_INSERT_ID()'];

            $sql = "UPDATE `bookings`
                    SET `order_id` = $orderId
                    WHERE `id` IN (" . implode(',', $petIds) . ")
            ";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE `product_bookings`
                    SET `order_id` = $orderId
                    WHERE `id` IN (" . implode(',', $productIds) . ")
            ";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE `services`
                    SET `order_id` = $orderId
                    WHERE `id` IN (" . implode(',', $serviceIds) . ")
            ";
            $result = mysqli_query($conn, $sql);

            if (mysqli_affected_rows($conn) > 0) {
                $_SESSION['success'] = 'Payment of Rs. ' . $amount . ' successful';
                echo '<meta http-equiv="refresh" content="0; URL=bookings.php">';
                exit();
            } else {
                $_SESSION['error'] = 'Payment of Rs. ' . $amount . ' failed';
            }
        } else {
            $_SESSION['error'] = 'Payment of Rs. ' . $amount . ' failed';
        }
    }
}

$subtotal = 0;
$delivery = 50;
$pid = "";

?>
<div class="container mt-3">
    <div class="row gy-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    My Bookings
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-12">
                            <?php
                            include 'alert.php';
                            ?>
                        </div>
                    </div>
                    <div class="row gy-3">
                        <div class="col-md-12">

                            <?php
                            $petid = "";
                            $sql = "SELECT 
                                        b.id as id,
                                        p.id as pid,
                                        p.image as image,
                                        p.name as name,
                                        b.quantity as quantity,
                                        b.unit_price as unit_price,
                                        b.quantity * b.unit_price as total_price
                                    FROM bookings AS b
                                    INNER JOIN pets p ON p.id = b.pet_id
                                    WHERE b.user_id = $user[id]
                                    AND `order_id` IS NULL";
                            $petBookingResult = mysqli_query($conn, $sql);
                            $petBookingCount = mysqli_num_rows($petBookingResult);
                            if ($petBookingCount > 0) {
                                $petid = 'pet';
                            ?>
                                <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Pet Name</th>
                                            <th>Pet By</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($petBookingResult)) {
                                            $subtotal += $row['total_price'];
                                            $petid .= '-' . $row['id'];
                                        ?>
                                            <tr class="align-middle">
                                                <td>
                                                    <img src="uploads/<?php echo $row['image']; ?>" alt="" width="100">
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo getVendorNameById('pets', $row['pid']); ?></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td>NRs. <?php echo $row['unit_price']; ?></td>
                                                <td>NRs. <?php echo $row['total_price']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            <?php
                            }
                            $proid = "";
                            $sql = "SELECT 
                                        b.id as id,
                                        p.id as pid,
                                        p.image as image,
                                        p.name as name,
                                        b.quantity as quantity,
                                        b.unit_price as unit_price,
                                        b.quantity * b.unit_price as total_price
                                    FROM product_bookings AS b
                                    INNER JOIN products p ON p.id = b.product_id
                                    WHERE b.user_id = $user[id]
                                    AND `order_id` IS NULL";
                            $productBookingResult = mysqli_query($conn, $sql);
                            $productBookingCount = mysqli_num_rows($productBookingResult);
                            if ($productBookingCount > 0) {
                                $proid = 'product';
                            ?>
                                <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Product By</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($productBookingResult)) {
                                            $subtotal += $row['total_price'];
                                            $proid .= '-' . $row['id'];
                                        ?>
                                            <tr class="align-middle">
                                                <td>
                                                    <img src="uploads/<?php echo $row['image']; ?>" alt="" width="100">
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo getVendorNameById('products', $row['pid']); ?></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td>NRs. <?php echo $row['unit_price']; ?></td>
                                                <td>NRs. <?php echo $row['total_price']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            <?php
                            }
                            $serid = "";
                            $sql = "SELECT 
                                        *
                                    FROM services 
                                    WHERE user_id = $user[id]
                                    AND `order_id` IS NULL";
                            $servicesBookingResult = mysqli_query($conn, $sql);
                            $servicesBookingCount = mysqli_num_rows($servicesBookingResult);
                            if ($servicesBookingCount > 0) {
                            $serid = 'service';
                            ?>
                                <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Pet Name</th>
                                            <th>Service</th>
                                            <th>Pet Size</th>
                                            <th>Booked For</th>
                                            <th>Booked At</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($servicesBookingResult)) {
                                            $subtotal += $row['price'];
                                            $serid .= '-' . $row['id'];
                                        ?>
                                            <tr class="align-middle">
                                                <td><?php echo $row['pet_name']; ?></td>
                                                <td><?php echo ucwords($row['service']); ?></td>
                                                <td><?php echo ucwords($row['pet_size']); ?></td>
                                                <td><?php echo date('d M Y H:i', strtotime($row['booked_for'])); ?></td>
                                                <td><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                                                <td>NRs. <?php echo $row['price']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            <?php
                            }

                            if ($petBookingCount == 0 && $productBookingCount == 0 && $servicesBookingCount == 0) {
                                echo '<div class="alert alert-warning">No bookings found</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- payment -->
            <div class="card">
                <div class="card-header">
                    Payment
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-12">

                        </div>
                    </div>
                    <div class="row gy-3">
                        <div class="col-md-12">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td class="text-end">NRs. <?php echo $subtotal; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Delivery</th>
                                        <td class="text-end">NRs.
                                            <?php
                                            $subtotal > 0 ? $delivery = 50 : $delivery = 0;
                                            echo $delivery;
                                            ?></td>
                                    <tr>
                                        <th>Total</th>
                                        <td class="text-end">NRs. <?php echo ($subtotal + $delivery); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                    if ($subtotal > 0) {
                        $pid = $petid . '_' . $proid . '_' . $serid;
                    ?>
                        <div class="row gy-3">
                            <div class="col-md-12">
                                <form action="https://uat.esewa.com.np/epay/main" method="POST">
                                    <input value="<?php echo ($subtotal + $delivery); ?>" name="tAmt" type="hidden">
                                    <input value="<?php echo $subtotal; ?>" name="amt" type="hidden">
                                    <input value="0" name="txAmt" type="hidden">
                                    <input value="0" name="psc" type="hidden">
                                    <input value="<?php echo $delivery; ?>" name="pdc" type="hidden">
                                    <input value="EPAYTEST" name="scd" type="hidden">
                                    <input value="<?php echo $pid; ?>" name="pid" type="hidden">
                                    <input value="<?php echo ($domain . '/bookings.php?payment=success&amount=' . ($subtotal + $delivery)); ?>" type="hidden" name="su">
                                    <input value="<?php echo ($domain . '/bookings.php?payment=failure&amount=' . ($subtotal + $delivery)); ?>" type="hidden" name="fu">
                                    <input value="Proceed to Payment" type="submit" class="btn btn-success w-100">
                                </form>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>