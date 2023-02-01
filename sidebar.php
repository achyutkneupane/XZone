<style>
    .list-group {
        background-color: transparent;
        border: none;
        box-shadow: none;
    }

    .list-group-item {
        background-color: #F5F5F5;
        border: none;
        font-size: 1.2em;
        font-weight: bold;
        color: #4CAF50;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: all 0.3s ease-in-out;
        padding: 15px;
        margin-bottom: 5px;
        border-radius: 5px;
    }

    .list-group-item:hover {
        background-color: #4CAF50;
        color: #F5F5F5;
    }

    .list-group-item.active {
        color: #F5F5F5;
    }
</style>
<div class="list-group col-md-3">
    <a href="/dashboard" class="list-group-item list-group-item-action
    <?php if ($route == 'index.php') {
        echo 'list-group-item-success active';
    } ?>" <?php if ($route == 'index.php') {
                echo 'aria-current="true"';
            } ?>>
        Dashboard
    </a>

    <!-- review pets -->
    <?php if ($isAdmin) { ?>
        <a href="/dashboard/review-pets.php" class="list-group-item list-group-item-action
        <?php if ($route == 'review-pets.php') {
            echo 'list-group-item-success active';
        } ?>" <?php if ($route == 'review-pets.php') {
                    echo 'aria-current="true"';
                } ?>>
            Review Pets
        </a>
    <?php } ?>

    <!-- add pet -->
    <a href="/dashboard/add-pet.php" class="list-group-item list-group-item-action
    <?php if ($route == 'add-pet.php') {
        echo 'list-group-item-success active';
    } ?>" <?php if ($route == 'add-pet.php') {
                echo 'aria-current="true"';
            } ?>>
        Add Pet
    </a>

    <!-- add product -->
    <a href="/dashboard/add-product.php" class="list-group-item list-group-item-action
    <?php if ($route == 'add-product.php') {
        echo 'list-group-item-success active';
    } ?>" <?php if ($route == 'add-product.php') {
                echo 'aria-current="true"';
            } ?>>
        Add Pet Product
    </a>

    <!-- view profile -->
    <a href="/dashboard/profile.php" class="list-group-item list-group-item-action
    <?php if ($route == 'profile.php') {
        echo 'list-group-item-success active';
    } ?>" <?php if ($route == 'profile.php') {
                echo 'aria-current="true"';
            } ?>>
        View Profile
    </a>

    <!-- view business -->
    <?php if ($isVendor) { ?>
        <a href="/dashboard/business-info.php" class="list-group-item list-group-item-action
        <?php if ($route == 'business-info.php') {
            echo 'list-group-item-success active';
        } ?>" <?php if ($route == 'business-info.php') {
                    echo 'aria-current="true"';
                } ?>>
            View Business
        </a>
    <?php } ?>

    <!-- edit profile -->
    <a href="/dashboard/edit-profile.php" class="list-group-item list-group-item-action
            <?php if ($route == 'edit-profile.php') {
                echo 'list-group-item-success active';
            } ?>" <?php if ($route == 'edit-profile.php') {
                        echo 'aria-current="true"';
                    } ?>>
        Edit Profile
    </a>

</div>