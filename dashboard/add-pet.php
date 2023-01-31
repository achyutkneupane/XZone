<title>Add Pets</title>
<?php
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pet_name = $_POST['pet_name'];
    $pet_slug = slugify($pet_name);
    $pet_description = $_POST['pet_description'];
    $pet_price = $_POST['pet_price'];
    $pet_quantity = $_POST['pet_quantity'];
    $pet_category = $_POST['pet_category'];
    $pet_image = $_FILES['pet_image']['name'];
    $tmp_name = $_FILES['pet_image']['tmp_name'];
    $path = '../images/pets/' . $pet_image;
    move_uploaded_file($tmp_name, $path);

    $sql = "INSERT INTO pets (name, slug, description, price, quantity, category_id, user_id, image) VALUES ('$pet_name', '$pet_slug', '$pet_description', '$pet_price', '$pet_quantity', '$pet_category', '$user[id]', '$path')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Pet added';
        petAddedMail($user['name'], $user['email']);
    } else {
        $_SESSION['error'] = 'Failed to add pet';
    }
}
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';

        $sql = "SELECT * FROM categories";
        $result = mysqli_query($conn, $sql);
        $categories = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $categories[] = $row;
            }
        }
        ?>
        <div class="col-md-9">
            <form class="card" action="add-pet.php" method="POST" enctype="multipart/form-data">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Add Pet
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </div>

                <div class="card-body">
                    <?php
                    include '../alert.php';
                    ?>
                    <div class="row gy-3 mb-3 align-items-center">
                        <label for="pet_name" class="col-md-4 col-form-label text-md-end">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" placeholder="Enter pet name" name="pet_name" value="" required autocomplete="pet_name" autofocus>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-center">
                        <label for="pet_image" class="col-md-4 col-form-label text-md-end">Image</label>

                        <div class="col-md-6">
                            <input id="pet_image" type="file" class="form-control" placeholder="Enter pet name" name="pet_image" value="" required autocomplete="pet_image" autofocus>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-start">
                        <label for="pet_category" class="col-md-4 col-form-label text-md-end">Category</label>

                        <div class="col-md-6">
                            <select name="pet_category" id="pet_category" class="form-control">
                                <option value="" selected disabled>Select Category</option>
                                <?php
                                foreach ($categories as $category) {
                                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                                }
                                ?>
                            </select>
                            <a class="btn btn-link" href="add-category.php">Add Category</a>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-start">
                        <label for="pet_description" class="col-md-4 col-form-label text-md-end">Description</label>
                        <div class="col-md-6">
                            <textarea name="pet_description" id="pet_description" placeholder="Enter Description" rows="4" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-center">
                        <label for="pet_price" class="col-md-4 col-form-label text-md-end">Price</label>

                        <div class="col-md-6">
                            <input id="pet_price" type="number" class="form-control" placeholder="Enter price" name="pet_price" value="" required autocomplete="pet_price" autofocus>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-center">
                        <label for="pet_quantity" class="col-md-4 col-form-label text-md-end">Quantity</label>

                        <div class="col-md-6">
                            <input id="pet_quantity" type="number" class="form-control" placeholder="Enter stock amount" name="pet_quantity" value="" required autocomplete="pet_quantity" autofocus>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php
include '../footer.php';
?>