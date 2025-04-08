<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/plain');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "techhub";

echo "Starting table fix...\n";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "Connected to database successfully\n";

    // Drop existing tables in correct order to handle foreign key constraints
    echo "Dropping existing tables...\n";
    
    // First drop order_items (has foreign key to orders)
    $conn->query("DROP TABLE IF EXISTS order_items");
    echo "- Dropped order_items table\n";
    
    // Then drop orders (has foreign key to customers)
    $conn->query("DROP TABLE IF EXISTS orders");
    echo "- Dropped orders table\n";
    
    // Finally drop customers
    $conn->query("DROP TABLE IF EXISTS customers");
    echo "- Dropped customers table\n";

    // Create customers table
    $sql_customers = "CREATE TABLE customers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20),
        address TEXT,
        city VARCHAR(100),
        state VARCHAR(100),
        country VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($sql_customers) === TRUE) {
        echo "Customers table created successfully\n";
    } else {
        throw new Exception("Error creating customers table: " . $conn->error);
    }

    // Create orders table
    $sql_orders = "CREATE TABLE orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_id INT,
        order_number VARCHAR(50) NOT NULL UNIQUE,
        status VARCHAR(50) DEFAULT 'Pending',
        subtotal DECIMAL(10, 2) NOT NULL,
        shipping DECIMAL(10, 2) NOT NULL,
        tax DECIMAL(10, 2) NOT NULL,
        total DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($sql_orders) === TRUE) {
        echo "Orders table created successfully\n";
    } else {
        throw new Exception("Error creating orders table: " . $conn->error);
    }

    // Create order_items table
    $sql_order_items = "CREATE TABLE order_items (
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
        echo "Order_items table created successfully\n";
    } else {
        throw new Exception("Error creating order_items table: " . $conn->error);
    }

    // Verify tables exist
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        echo "\nCurrent tables in database:\n";
        while ($row = $result->fetch_row()) {
            echo "- " . $row[0] . "\n";
        }
    } else {
        throw new Exception("Error listing tables: " . $conn->error);
    }

    // Close connection
    $conn->close();
    echo "\nTable fix completed successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    if (isset($conn)) {
        $conn->close();
    }
}
?> 