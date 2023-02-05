<title>My Pets</title>
<?php
include '../header.php';

if(isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM pets WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $_SESSION['success'] = 'Pet deleted successfully!';
    } else {
        $_SESSION['error'] = 'Something went wrong!';
    }
    echo '<meta http-equiv="refresh" content="0; URL=/dashboard/my-pets.php">';
    exit();
}
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';
        ?>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">My Pets</div>

                <div class="card-body">
                    <?php
                    include '../alert.php';

                    $sql = "SELECT * FROM pets WHERE user_id = " . $user['id'];
                    $result = mysqli_query($conn, $sql);
                    $petsCount = mysqli_num_rows($result);

                    if($petsCount > 0) {
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Pet Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            while($row = mysqli_fetch_assoc($result)) {
                                $petName = $row['name'];
                                $petPrice = $row['price'];
                                $petQuantity = $row['quantity'];
                                $petImage = $row['image'];

                                echo "<tr>";
                                echo "<td>$petName</td>";
                                echo "<td><img src='$petImage' width='100' height='100'></td>";
                                echo "<td>$petPrice</td>";
                                echo "<td>$petQuantity</td>";
                                echo "<td>
                                        <form action='my-pets.php' method='post'>
                                            <input type='hidden' name='id' value='$row[id]'>
                                            <input type='submit' class='btn btn-danger' name='delete' value='Delete'>
                                        </form>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    } else {
                        echo '<div class="alert alert-warning" role="alert">';
                        echo 'You have not added any pets yet. <a href="add-pet.php">Add a pet</a> to continue.';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    include '../footer.php';
