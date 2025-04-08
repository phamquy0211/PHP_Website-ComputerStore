<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/plain');

echo "Checking MySQL connection...\n\n";

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";

try {
    // Try connecting without database first
    $conn = new mysqli($servername, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "✓ Successfully connected to MySQL server\n";
    echo "MySQL Server Info:\n";
    echo "- Version: " . $conn->server_info . "\n";
    echo "- Character Set: " . $conn->character_set_name() . "\n";
    
    // Check if techhub database exists
    $result = $conn->query("SHOW DATABASES LIKE 'techhub'");
    if ($result->num_rows > 0) {
        echo "✓ Database 'techhub' exists\n";
        
        // Select techhub database
        if ($conn->select_db('techhub')) {
            echo "✓ Successfully connected to 'techhub' database\n";
            
            // Check tables
            $result = $conn->query("SHOW TABLES");
            if ($result) {
                echo "\nTables in techhub database:\n";
                while ($row = $result->fetch_row()) {
                    // Check table status
                    $status = $conn->query("CHECK TABLE `{$row[0]}`");
                    $status_row = $status->fetch_assoc();
                    $status_msg = ($status_row['Msg_text'] === 'OK') ? '✓' : '✗';
                    echo "$status_msg {$row[0]}\n";
                    
                    // Show table engine
                    $engine = $conn->query("SHOW TABLE STATUS WHERE Name = '{$row[0]}'");
                    $engine_row = $engine->fetch_assoc();
                    echo "  - Engine: {$engine_row['Engine']}\n";
                    echo "  - Rows: {$engine_row['Rows']}\n";
                }
            }
        } else {
            echo "✗ Could not select 'techhub' database\n";
        }
    } else {
        echo "✗ Database 'techhub' does not exist\n";
    }
    
    $conn->close();
    echo "\nCheck completed.\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    if (isset($conn)) {
        $conn->close();
    }
}
?> 