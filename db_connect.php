<?php
// Enable error reporting for debugging when accessed directly
if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header('Content-Type: text/plain');
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "techhub";

$conn = null; // Initialize $conn to null

try {
    // First connect without database selected
    $conn_check = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn_check->connect_error) {
        throw new Exception("Database connection failed: " . $conn_check->connect_error);
    }

    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        echo "Connected to MySQL server successfully\n";
    }

    // Create the database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($conn_check->query($sql) !== TRUE) {
        throw new Exception("Error creating database: " . $conn_check->error);
    }

    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        echo "Database '$dbname' created or verified\n";
    }

    // Close initial check connection
    $conn_check->close();

    // Establish the actual connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Database connection failed (after select_db): " . $conn->connect_error);
    }

    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        echo "Connected to database '$dbname' successfully\n";
    }

    // Set charset to utf8mb4
    if (!$conn->set_charset("utf8mb4")) {
        throw new Exception("Error loading character set utf8mb4: " . $conn->error);
    }

    // Create customers table
    $sql_customers = "CREATE TABLE IF NOT EXISTS customers (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    if ($conn->query($sql_customers) === FALSE) {
        throw new Exception("Error creating table 'customers': " . $conn->error);
    }

    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        echo "Customers table created or verified\n";
    }

    // Create orders table
    $sql_orders = "CREATE TABLE IF NOT EXISTS orders (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    if ($conn->query($sql_orders) === FALSE) {
        throw new Exception("Error creating table 'orders': " . $conn->error);
    }

    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        echo "Orders table created or verified\n";
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    if ($conn->query($sql_order_items) === FALSE) {
        throw new Exception("Error creating table 'order_items': " . $conn->error);
    }

    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        echo "Order_items table created or verified\n";
    }

    // Create cart_items table
    $sql_cart_items = "CREATE TABLE IF NOT EXISTS cart_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        image_url VARCHAR(255),
        specs TEXT,
        session_id VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX(session_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    if ($conn->query($sql_cart_items) === FALSE) {
        throw new Exception("Error creating table 'cart_items': " . $conn->error);
    }
    
    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        echo "Cart_items table created or verified\n";
    }

    // Create support_tickets table
    $sql_support_tickets = "CREATE TABLE IF NOT EXISTS support_tickets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        order_number VARCHAR(50),
        subject VARCHAR(255) NOT NULL,
        category VARCHAR(50) NOT NULL,
        priority VARCHAR(20) NOT NULL,
        message TEXT NOT NULL,
        admin_notes TEXT,
        status VARCHAR(50) DEFAULT 'Open',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    if ($conn->query($sql_support_tickets) === FALSE) {
        throw new Exception("Error creating table 'support_tickets': " . $conn->error);
    }
    
    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        echo "Support_tickets table created or verified\n";
    }

    // Show tables if accessed directly
    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        $result = $conn->query("SHOW TABLES");
        if ($result) {
            echo "\nCurrent tables in database:\n";
            while ($row = $result->fetch_row()) {
                echo "- " . $row[0] . "\n";
            }
        }
    }

} catch (Exception $e) {
    if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
        echo "Error: " . $e->getMessage() . "\n";
    }
    error_log("Database setup error in db_connect.php: " . $e->getMessage());
    $conn = null;
}

// Note: $conn might be null if the try block failed.
// The including script must check if $conn is valid.

if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
    echo "\nDatabase connection script completed.\n";
}
?>