<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "techhub";

echo "Checking database connection...\n";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "Connected to MySQL server successfully\n";

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Database '$dbname' created or already exists\n";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }

    // Select the database
    if ($conn->select_db($dbname)) {
        echo "Selected database '$dbname' successfully\n";
    } else {
        throw new Exception("Error selecting database: " . $conn->error);
    }

    // Check tables
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        echo "\nTables in database:\n";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_row()) {
                echo "- " . $row[0] . "\n";
            }
        } else {
            echo "No tables found\n";
        }
    } else {
        throw new Exception("Error listing tables: " . $conn->error);
    }

    // Close connection
    $conn->close();
    echo "\nDatabase check completed successfully\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 