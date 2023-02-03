<style>
    .navbar {
        padding: 10px;
        box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
    }

    .navbar-brand {
        font-size: 1.5em;
        font-weight: bold;
        color: white;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-right: 30px;
    }

    .navbar-nav {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .nav-item {
        margin: 0 20px;
    }

    .nav-link {
        font-size: 1.2em;
        font-weight: bold;
        color: white;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding: 10px;
        transition: all 0.3s ease-in-out;
    }

    .nav-link:hover {
        color: #ffffff;
        background-color: #4CAF50;
        padding: 10px;
        border-radius: 5px
    }

    .navbar-toggler {
        border-color: white;
    }
</style>
<nav class="navbar navbar-expand-md navbar-dark bg-success shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            XZone
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="about-us.php">About Us</a>
                </li>
                <!-- Authentication Links -->
                <?php
                if (!isset($_SESSION['user'])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>
                    <?php
                    if (!$isAdmin && !$isVendor) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/bookings.php">My Bookings</a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <?php echo $user['name']; ?>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo $domain; ?>/logout.php">
                                Logout
                            </a>
                        </div>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>