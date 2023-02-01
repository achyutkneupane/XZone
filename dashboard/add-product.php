<title>Add Products</title>
<?php
include '../header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];
    $product_image = $_FILES['product_image']['name'];
    $tmp_name = $_FILES['product_image']['tmp_name'];
    $path = '../images/products/' . $product_image;
    move_uploaded_file($tmp_name, $path);

    $sql = "INSERT INTO products (name, description, price, category_id, image, user_id) VALUES ('$product_name', '$product_description', '$product_price', '$product_category', '$path', '$user[id]')";

    if(mysqli_query($conn, $sql)){
        $_SESSION['success'] = 'Product added';
    }else{
        $_SESSION['error'] = 'Failed to add product';
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
            <form class="card" action="add-product.php" method="POST" enctype="multipart/form-data">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Add Product
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
                        <label for="product_name" class="col-md-4 col-form-label text-md-end">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" placeholder="Enter product name" name="product_name" value="" required autocomplete="product_name" autofocus>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-center">
                        <label for="product_image" class="col-md-4 col-form-label text-md-end">Image</label>

                        <div class="col-md-6">
                            <input id="product_image" type="file" class="form-control" placeholder="Enter product name" name="product_image" value="" required autocomplete="product_image" autofocus>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-start">
                        <label for="product_category" class="col-md-4 col-form-label text-md-end">Category</label>

                        <div class="col-md-6">
                            <select name="product_category" id="product_category" class="form-control">
                                <option value="" selected disabled>Select Category</option>
                                <?php
                                foreach ($categories as $category) {
                                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                                }
                                ?>
                            </select>
                            <a class="btn btn-link mt-2" href="add-category.php">Add Category</a>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-start">
                        <label for="product_description" class="col-md-4 col-form-label text-md-end">Description</label>
                        <div class="col-md-6">
                            <textarea name="product_description" id="product_description" placeholder="Enter Description" rows="4" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-center">
                        <label for="product_price" class="col-md-4 col-form-label text-md-end">Price</label>

                        <div class="col-md-6">
                            <input id="product_price" type="number" class="form-control" placeholder="Enter price" name="product_price" value="" required autocomplete="product_price" autofocus>
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