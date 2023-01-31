<title>My Bookings</title>
<?php
include 'header.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == "book") {
        $product_id = isset($_GET['product']) ? $_GET['product'] : '';
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
    }
}

if(isset($_GET['payment'])) {
    $status = $_GET['payment'];
    if(isset($_GET['amount'])) {
        $amount = $_GET['amount'];

        if($status == 'success') {
            $refId = $_GET['refId'];
            $oid = $_GET['oid'];
            $bookingIds = explode('-', $oid);
            $bookings = array_slice($bookingIds, 1);

            $sql = "INSERT INTO orders
                    (`paid_at`, `esewa_reference`)
                    VALUE (NOW(), '$refId')";
            $result = mysqli_query($conn, $sql);

            $orderId = "SELECT LAST_INSERT_ID()";
            $result = mysqli_query($conn, $orderId);
            $orderId = mysqli_fetch_assoc($result)['LAST_INSERT_ID()'];

            $sql = "UPDATE `bookings`
                    SET `order_id` = $orderId
                    WHERE `id` IN (" . implode(',', $bookings) . ")
            ";
            $result = mysqli_query($conn, $sql);

            if(mysqli_affected_rows($conn) > 0) {
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
$pid = 'product';

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
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                ?>
                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Pet By</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $subtotal += $row['total_price'];
                                        $pid .= '-'.$row['id'];
                                    ?>
                                        <tr class="align-middle">
                                            <td>
                                                <img src="uploads/<?php echo $row['image']; ?>" alt="" width="100">
                                            </td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo getVendorNameByPetId($row['pid']); ?></td>
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
                            } else {
                                echo '<h4 class="text-center">No bookings yet</h4>';
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
                    if($subtotal > 0) {
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
                                <input value="<?php echo($domain.'/bookings.php?payment=success&amount='.($subtotal + $delivery)); ?>" type="hidden" name="su">
                                <input value="<?php echo($domain.'/bookings.php?payment=failure&amount='.($subtotal + $delivery)); ?>" type="hidden" name="fu">
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