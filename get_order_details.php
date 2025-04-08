<?php
// Ensure no direct output
ob_start();

// Set headers to ensure JSON response
header('Content-Type: application/json');

// Enable error reporting for debugging, but don't display
error_reporting(E_ALL);
ini_set('display_errors', 0); 

$response = [];

try {
    // Validate Order ID
    if (!isset($_GET['order_id']) || !filter_var($_GET['order_id'], FILTER_VALIDATE_INT)) {
        throw new Exception("Invalid or missing Order ID.");
    }
    $order_id = (int)$_GET['order_id'];

    require_once 'db_connect.php';

    // Check if DB connection was successful
    if ($conn === null || $conn->connect_error) {
        throw new Exception("Database connection failed. Check server logs.");
    }

    // --- Fetch Order Details ---
    $sql_order = "SELECT * FROM orders WHERE id = ?";
    $stmt_order = $conn->prepare($sql_order);
    if (!$stmt_order) {
        throw new Exception("Error preparing order query: " . $conn->error);
    }
    $stmt_order->bind_param("i", $order_id);
    if (!$stmt_order->execute()) {
        throw new Exception("Error executing order query: " . $stmt_order->error);
    }
    $result_order = $stmt_order->get_result();
    $order_details = $result_order->fetch_assoc();
    $stmt_order->close();

    if (!$order_details) {
        throw new Exception("Order not found.");
    }

    // --- Fetch Order Items ---
    $sql_items = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt_items = $conn->prepare($sql_items);
    if (!$stmt_items) {
        throw new Exception("Error preparing order items query: " . $conn->error);
    }
    $stmt_items->bind_param("i", $order_id);
    if (!$stmt_items->execute()) {
        throw new Exception("Error executing order items query: " . $stmt_items->error);
    }
    $result_items = $stmt_items->get_result();
    $order_items = [];
    while ($row = $result_items->fetch_assoc()) {
        $order_items[] = $row;
    }
    $stmt_items->close();

    // --- Prepare Success Response ---
    $response = [
        'success' => true,
        'order' => $order_details,
        'items' => $order_items
    ];

} catch (Exception $e) {
    // Log the detailed error
    error_log("Error in get_order_details.php: " . $e->getMessage() . "\nStack Trace:\n" . $e->getTraceAsString());
    
    // Set error response
    $response = [
        'success' => false,
        'message' => $e->getMessage() // Send back the specific error message
    ];
}

// Clean the output buffer before sending JSON
ob_end_clean();

// Send the JSON response
echo json_encode($response);

// Close database connection if it was opened
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}

exit; // Ensure no further processing
?> 