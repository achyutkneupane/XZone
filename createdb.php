<?php

include 'db.php';

$sql = "CREATE TABLE IF NOT EXISTS users (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(30) NOT NULL,
    `password` VARCHAR(30) NOT NULL,
    `email` VARCHAR(50) UNIQUE,
    `role` ENUM('admin', 'customer', 'vendor') DEFAULT 'customer',
    `phone` VARCHAR(10),
    `profile_picture` VARCHAR(100),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

if (!mysqli_query($conn, $sql)) {
    die("Error creating users table: " . mysqli_error($conn));
}

$sql = "CREATE TABLE IF NOT EXISTS categories (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(30) NOT NULL,
    `slug` VARCHAR(30) NOT NULL,
    `description` VARCHAR(100),
    `image` VARCHAR(100),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

if (!mysqli_query($conn, $sql)) {
    die("Error creating categories table: " . mysqli_error($conn));
}

$sql = "CREATE TABLE IF NOT EXISTS vendors (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(30) NOT NULL,
    `email` VARCHAR(50),
    `phone` VARCHAR(10),
    `address` VARCHAR(100),
    `profile_picture` VARCHAR(100),
    `user_id` INT(6) UNSIGNED,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
    )";

if (!mysqli_query($conn, $sql)) {
    die("Error creating vendors table: " . mysqli_error($conn));
}

$sql = "CREATE TABLE IF NOT EXISTS pets (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(30) NOT NULL,
    `slug` VARCHAR(30) NOT NULL,
    `description` VARCHAR(100),
    `image` VARCHAR(100),
    `price` DECIMAL(8, 2),
    `quantity` INT(6),
    `approved_at` TIMESTAMP NULL DEFAULT NULL,
    `category_id` INT(6) UNSIGNED,
    `user_id` INT(6) UNSIGNED,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES categories(`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
    )";

if (!mysqli_query($conn, $sql)) {
    die("Error creating pets table: " . mysqli_error($conn));
}

$sql = "CREATE TABLE IF NOT EXISTS reviews (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `rating` DECIMAL(2, 1),
    `review` VARCHAR(100),
    `user_id` INT(6) UNSIGNED,
    `pet_id` INT(6) UNSIGNED,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    FOREIGN KEY (`pet_id`) REFERENCES pets(`id`)
    )";

if (!mysqli_query($conn, $sql)) {
    die("Error creating reviews table: " . mysqli_error($conn));
}


$sql = "CREATE TABLE IF NOT EXISTS orders (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `paid_at` TIMESTAMP NULL DEFAULT NULL,
    `esewa_reference` VARCHAR(100) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $sql)) {
    die("Error creating orders table: " . mysqli_error($conn));
}

$sql = "CREATE TABLE IF NOT EXISTS bookings (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT(6) UNSIGNED,
    `pet_id` INT(6) UNSIGNED,
    `quantity` INT(6),
    `unit_price` DECIMAL(8, 2),
    `order_id` INT(6) UNSIGNED NULL DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    FOREIGN KEY (`pet_id`) REFERENCES pets(`id`),
    FOREIGN KEY (`order_id`) REFERENCES orders(`id`) ON DELETE SET NULL
)";

if (!mysqli_query($conn, $sql)) {
    die("Error creating bookings table: " . mysqli_error($conn));
}

$sql = "CREATE TABLE IF NOT EXISTS products (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(30) NOT NULL,
    `description` VARCHAR(100),
    `image` VARCHAR(100),
    `price` DECIMAL(8, 2),
    `category_id` INT(6) UNSIGNED,
    `user_id` INT(6) UNSIGNED,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES categories(`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
    )";

if (!mysqli_query($conn, $sql)) {
    die("Error creating products table: " . mysqli_error($conn));
}

$sql = "CREATE TABLE IF NOT EXISTS services (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT(6) UNSIGNED,
    `pet_name` VARCHAR(30) NOT NULL,
    `service` VARCHAR(30) NOT NULL,
    `pet_size` VARCHAR(30) NOT NULL,
    `price` DECIMAL(8, 2),
    `booked_for` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
    )";

if (!mysqli_query($conn, $sql)) {
    die("Error creating services table: " . mysqli_error($conn));
}

$sql = "CREATE TABLE IF NOT EXISTS product_bookings (
    `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT(6) UNSIGNED,
    `product_id` INT(6) UNSIGNED,
    `quantity` INT(6),
    `unit_price` DECIMAL(8, 2),
    `order_id` INT(6) UNSIGNED NULL DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    FOREIGN KEY (`product_id`) REFERENCES products(`id`),
    FOREIGN KEY (`order_id`) REFERENCES orders(`id`) ON DELETE SET NULL
)";

if (!mysqli_query($conn, $sql)) {
    die("Error creating product_bookings table: " . mysqli_error($conn));
}



$sql = "SELECT * FROM users WHERE role = 'admin'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) <= 0) {
    $sql = "INSERT INTO users (`name`, `email`, `role`, `password`) VALUES ('Admin', 'admin@xzone.com', 'admin', 'password'), ('Vendor', 'vendor@xzone.com', 'vendor', 'password')";
    if (!mysqli_query($conn, $sql)) {
        die("Error inserting users: " . mysqli_error($conn));
    }
}

$sql = "SHOW COLUMNS FROM users LIKE 'has_business'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) <= 0) {
    $sql = "ALTER TABLE users ADD COLUMN has_business BOOLEAN DEFAULT FALSE";
    if (!mysqli_query($conn, $sql)) {
        die("Error adding column has_business to users: " . mysqli_error($conn));
    }
}