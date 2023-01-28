<title>Dashboard</title>
<?php
include '../header.php';
?>
<div class="container mt-3">
    <div class="row gy-3">
        <?php
        include '../sidebar.php';
        ?>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <?php
                    include '../alert.php';
                    // if ($_SESSION['status']) {
                    //     echo '<div class="alert alert-success" role="alert">';
                    //     echo $_SESSION['status'];
                    //     echo '</div>';
                    // }
                    ?>
                    <?php
                    echo 'You are logged in as <strong>' . getRole() . '</strong> !';
                    ?>
                </div>
        </div>
    </div>
</div>
<?php
include '../footer.php';