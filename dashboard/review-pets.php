<title>Review Pets</title>
<?php
include '../header.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    if ($action == 'reject') {
        $sql = "DELETE FROM pets WHERE id = '$id'";
    } else {
        $sql = "UPDATE pets SET `approved_at` = CURRENT_TIMESTAMP WHERE id = '$id'";
    }
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if($action == 'reject')
            $_SESSION['error'] = 'Pet rejected successfully';
        else
            $_SESSION['success'] = 'Pet approved successfully';
    }
}
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';
        ?>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Review Pets
                    </div>
                    <div>
                    </div>
                </div>

                <div class="card-body">
                    <?php
                    include '../alert.php';
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT
                                        p.id AS pet_id,
                                        p.name AS pet_name,
                                        c.name AS category_name,
                                        p.price AS price,
                                        p.quantity AS quantity
                                        FROM pets AS p JOIN categories AS c ON p.category_id = c.id
                                        WHERE p.approved_at IS NULL
                                        ";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['pet_id'];
                                    $name = $row['pet_name'];
                                    $category = $row['category_name'];
                                    $price = $row['price'];
                                    $quantity = $row['quantity'];
                                    echo "<tr>
                                        <th scope='row'>$id</th>
                                        <td>$name</td>
                                        <td>$category</td>
                                        <td>$price</td>
                                        <td>$quantity</td>
                                        <td>
                                            <a href='review-pets.php?id=$id&action=approve' class='btn btn-success'>Approve</a>
                                            <a href='review-pets.php?id=$id&action=reject' class='btn btn-danger'>Reject</a>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr>
                                    <td colspan='6' class='text-center'>No Pets to approve</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include '../footer.php';
?>