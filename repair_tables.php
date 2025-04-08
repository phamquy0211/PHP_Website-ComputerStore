<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/plain');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "techhub";

echo "Starting database repair...\n\n";

try {
    // Connect without database first
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql)) {
        echo "✓ Database created/verified\n";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }

    // Select the database
    if (!$conn->select_db($dbname)) {
        throw new Exception("Could not select database: " . $conn->error);
    }

    // Set to use InnoDB
    $conn->query("SET default_storage_engine=InnoDB");
    
    // Drop tables in correct order
    echo "\nDropping existing tables...\n";
    $conn->query("SET FOREIGN_KEY_CHECKS=0");
    $tables = ['order_items', 'orders', 'customers'];
    foreach ($tables as $table) {
        if ($conn->query("DROP TABLE IF EXISTS `$table`")) {
            echo "✓ Dropped $table table\n";
        }
    }
    $conn->query("SET FOREIGN_KEY_CHECKS=1");

    echo "\nCreating tables...\n";

    // Create customers table
    $sql_customers = "CREATE TABLE `customers` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `first_name` VARCHAR(100) NOT NULL,
        `last_name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(100) NOT NULL,
        `phone` VARCHAR(20),
        `address` TEXT,
        `city` VARCHAR(100),
        `state` VARCHAR(100),
        `country` VARCHAR(100),
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY `email_unique` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($sql_customers)) {
        echo "✓ Created customers table\n";
    } else {
        throw new Exception("Error creating customers table: " . $conn->error);
    }

    // Create orders table
    $sql_orders = "CREATE TABLE `orders` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `customer_id` INT UNSIGNED,
        `session_id` VARCHAR(255),
        `order_number` VARCHAR(50) NOT NULL,
        `status` VARCHAR(50) DEFAULT 'Pending',
        `first_name` VARCHAR(100),
        `last_name` VARCHAR(100),
        `email` VARCHAR(100),
        `phone` VARCHAR(20),
        `address` TEXT,
        `city` VARCHAR(100),
        `state` VARCHAR(100),
        `country` VARCHAR(100),
        `zip_code` VARCHAR(20),
        `payment_method` VARCHAR(50),
        `order_notes` TEXT,
        `subtotal` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        `shipping` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        `tax` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        `total` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY `order_number_unique` (`order_number`),
        INDEX `idx_session_id` (`session_id`),
        CONSTRAINT `fk_orders_customer` FOREIGN KEY (`customer_id`) 
            REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($sql_orders)) {
        echo "✓ Created orders table\n";
    } else {
        throw new Exception("Error creating orders table: " . $conn->error);
    }

    // Create order_items table
    $sql_order_items = "CREATE TABLE `order_items` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `order_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `product_name` VARCHAR(255) NOT NULL,
        `price` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
        `specs` TEXT,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`)
            REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($sql_order_items)) {
        echo "✓ Created order_items table\n";
    } else {
        throw new Exception("Error creating order_items table: " . $conn->error);
    }

    // Verify tables
    echo "\nVerifying tables...\n";
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $table = $row[0];
        $check = $conn->query("CHECK TABLE `$table`");
        $check_result = $check->fetch_assoc();
        echo ($check_result['Msg_text'] === 'OK' ? "✓" : "✗") . " $table: {$check_result['Msg_text']}\n";
    }

    $conn->close();
    echo "\n✓ Database repair completed successfully!\n";
    echo "You can now try the checkout process again.\n";

} catch (Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    if (isset($conn)) {
        $conn->close();
    }
}
?> 