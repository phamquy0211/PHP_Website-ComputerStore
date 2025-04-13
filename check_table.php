<?php
require_once 'db_connect.php';

// Check if the users table exists
$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result->num_rows > 0) {
    echo "The 'users' table exists.<br>";
    
    // Check the structure of the users table
    $result = $conn->query("DESCRIBE users");
    echo "<pre>";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
    echo "</pre>";
    
    // Check if role column exists
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($result->num_rows == 0) {
        // Add role column if it doesn't exist
        $sql = "ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') NOT NULL DEFAULT 'user'";
        if ($conn->query($sql) === TRUE) {
            echo "Role column added successfully!";
        } else {
            echo "Error adding role column: " . $conn->error;
        }
    } else {
        echo "Role column already exists.";
    }

    // Check and add new profile columns if they don't exist
    $columns_to_add = [
        'gender' => "ALTER TABLE users ADD COLUMN gender ENUM('male', 'female', 'other') DEFAULT NULL",
        'phone' => "ALTER TABLE users ADD COLUMN phone VARCHAR(20) DEFAULT NULL",
        'date_of_birth' => "ALTER TABLE users ADD COLUMN date_of_birth DATE DEFAULT NULL",
        'avatar' => "ALTER TABLE users ADD COLUMN avatar VARCHAR(255) DEFAULT 'default-avatar.png'"
    ];

    foreach ($columns_to_add as $column => $sql) {
        $result = $conn->query("SHOW COLUMNS FROM users LIKE '$column'");
        if ($result->num_rows == 0) {
            if ($conn->query($sql) === TRUE) {
                echo "$column column added successfully!<br>";
            } else {
                echo "Error adding $column column: " . $conn->error . "<br>";
            }
        } else {
            echo "$column column already exists.<br>";
        }
    }
} else {
    echo "The 'users' table does not exist!<br>";
    
    // Create the users table
    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Users table created successfully!";
    } else {
        echo "Error creating users table: " . $conn->error;
    }
}
?> 