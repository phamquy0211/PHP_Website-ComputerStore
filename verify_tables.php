<?php
require_once 'db_connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if orders table exists
$result = $conn->query("SHOW TABLES LIKE 'orders'");
if ($result->num_rows == 0) {
    // Create orders table if it doesn't exist
    $sql = "CREATE TABLE orders (
        order_id INT AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        address TEXT NOT NULL,
        city VARCHAR(100) NOT NULL,
        state VARCHAR(100) NOT NULL,
        country VARCHAR(100) NOT NULL,
        total_amount DECIMAL(10,2) NOT NULL,
        shipping_amount DECIMAL(10,2) NOT NULL,
        tax_amount DECIMAL(10,2) NOT NULL,
        order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    if ($conn->query($sql) === TRUE) {
        echo "Orders table created successfully<br>";
    } else {
        echo "Error creating orders table: " . $conn->error . "<br>";
    }
} else {
    // Check columns in orders table
    $result = $conn->query("DESCRIBE orders");
    echo "Current orders table structure:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Column: " . $row['Field'] . ", Type: " . $row['Type'] . "<br>";
    }
}

// Check if order_items table exists
$result = $conn->query("SHOW TABLES LIKE 'order_items'");
if ($result->num_rows == 0) {
    // Create order_items table if it doesn't exist
    $sql = "CREATE TABLE order_items (
        order_item_id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        quantity INT NOT NULL,
        image_url VARCHAR(255),
        specs TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    if ($conn->query($sql) === TRUE) {
        echo "Order_items table created successfully<br>";
    } else {
        echo "Error creating order_items table: " . $conn->error . "<br>";
    }
} else {
    // Check columns in order_items table
    $result = $conn->query("DESCRIBE order_items");
    echo "Current order_items table structure:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Column: " . $row['Field'] . ", Type: " . $row['Type'] . "<br>";
    }
}

$conn->close();
?> 