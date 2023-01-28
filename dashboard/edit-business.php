<title>Edit Business</title>
<?php
include '../header.php';
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';

        $vendorName = $vendor ? $vendor['name'] : null;
        $vendorEmail = $vendor ? $vendor['email'] : null;
        $vendorPhone = $vendor ? $vendor['phone'] : null;
        $vendorAddress = $vendor ? $vendor['address'] : null;
        ?>
        <div class="col-md-9">
            <form class="card" action="business-info.php?update=details" method="POST">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Business Info
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row gy-3 mb-3 align-items-center">
                        <div class="col-md-12">
                            <?php
                            include '../alert.php';
                            ?>
                        </div>
                    </div>

                    <div class="row gy-3 mb-3 align-items-center">
                        <div class="row gy-3 mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" placeholder="Update your business name" name="name" value="<?php echo $vendorName; ?>" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="row gy-3 mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" placeholder="Update your email" name="email" value="<?php echo $vendorEmail; ?>" required autocomplete="email">
                            </div>
                        </div>

                        <div class="row gy-3 mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control" placeholder="Update your phone number" name="phone" value="<?php echo $vendorPhone; ?>" required autocomplete="phone" min="1000000000" maxlength="9999999999" />
                            </div>
                        </div>

                        <div class="row gy-3 mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" placeholder="Update your address" name="address" value="<?php echo $vendorAddress; ?>" required autocomplete="address">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function updateImage() {
        document.getElementById('profilePicture').click();
    }

    function updateImageForm() {
        document.getElementById('updateImageForm').submit();
    }
</script>
<?php
include '../footer.php';
?>