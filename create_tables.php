<?php
// Database setup script to create required tables

// Include database connection
require_once 'db_connect.php';

// Set content type to plain text for debugging output
header('Content-Type: text/plain');

// Function to create all required tables
function createTables($conn) {
    if ($conn === null) {
        echo "Error: Database connection is null\n";
        return false;
    }

    echo "Starting table creation...\n";
    
    // Create customers table
    $sql_customers = "CREATE TABLE IF NOT EXISTS customers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($sql_customers) === TRUE) {
        echo "✓ Customers table created successfully\n";
    } else {
        echo "✗ Error creating customers table: " . $conn->error . "\n";
        return false;
    }

    // Create orders table
    $sql_orders = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_id INT,
        session_id VARCHAR(255),
        order_number VARCHAR(50) NOT NULL,
        status VARCHAR(50) DEFAULT 'Pending',
        first_name VARCHAR(100),
        last_name VARCHAR(100),
        email VARCHAR(100),
        phone VARCHAR(20),
        address TEXT,
        city VARCHAR(100),
        state VARCHAR(100),
        country VARCHAR(100),
        zip_code VARCHAR(20),
        payment_method VARCHAR(50),
        order_notes TEXT,
        subtotal DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        shipping DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        tax DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($sql_orders) === TRUE) {
        echo "✓ Orders table created successfully\n";
    } else {
        echo "✗ Error creating orders table: " . $conn->error . "\n";
        return false;
    }

    // Create order_items table
    $sql_order_items = "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        quantity INT NOT NULL,
        specs TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($sql_order_items) === TRUE) {
        echo "✓ Order_items table created successfully\n";
    } else {
        echo "✗ Error creating order_items table: " . $conn->error . "\n";
        return false;
    }

    // Show all tables in the database
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        echo "\nCurrent tables in database:\n";
        while ($row = $result->fetch_row()) {
            echo "- " . $row[0] . "\n";
        }
    } else {
        echo "✗ Error listing tables: " . $conn->error . "\n";
        return false;
    }

    return true;
}

// Execute table creation
if ($conn !== null) {
    if (createTables($conn)) {
        echo "\n✓ All tables created successfully!\n";
    } else {
        echo "\n✗ There were errors creating the tables. Please check the output above.\n";
    }
} else {
    echo "✗ Error: Database connection not established.\n";
}

// Close connection
if ($conn !== null) {
    $conn->close();
}

echo "\nTable setup completed.";
?> 