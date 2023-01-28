<title>Add Pets</title>
<?php
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_image = $_FILES['category_image']['name'];
    $tmp_name = $_FILES['category_image']['tmp_name'];
    $path = '../images/categories/' . $category_image;
    move_uploaded_file($tmp_name, $path);

    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];
    $category_slug = slugify($category_name);

    $sql = "INSERT INTO categories (name, image, description, slug) VALUES ('$category_name', '$path', '$category_description', '$category_slug')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Category added';
    } else {
        $_SESSION['error'] = 'Failed to add category';
    }
}
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';
        ?>
        <div class="col-md-9">
            <form action="add-category.php" method="POST" class="card" enctype="multipart/form-data">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Add Category
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </div>

                <div class="card-body">
                    <?php
                    include '../alert.php';
                    ?>
                    <div class="mb-3">
                        <label for="category_image" class="col-form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name">
                    </div>
                    <div class="mb-3">
                        <label for="category_image" class="col-form-label">Category Image</label>
                        <input type="file" class="form-control" id="category_image" name="category_image">
                    </div>
                    <div class="mb-3">
                        <label for="category_description" class="col-form-label">Category Description</label>
                        <textarea class="form-control" id="category_description" name="category_description"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include '../footer.php';
?>