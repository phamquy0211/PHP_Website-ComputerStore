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
    // Check request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    // Validate Cart Item ID
    if (!isset($_POST['cart_item_id']) || !filter_var($_POST['cart_item_id'], FILTER_VALIDATE_INT)) {
        throw new Exception("Invalid or missing Cart Item ID.");
    }
    $cart_item_id = (int)$_POST['cart_item_id'];

    require_once 'db_connect.php';

    // Check if DB connection was successful
    if ($conn === null || $conn->connect_error) {
        throw new Exception("Database connection failed. Check server logs.");
    }

    // Start session to verify item belongs to current user (important!)
    if (session_status() === PHP_SESSION_NONE) {
        if (!session_start()) {
            throw new Exception("Failed to start session.");
        }
    }
    $session_id = session_id();

    // --- Delete Item (Ensure it belongs to the current session) ---
    $sql = "DELETE FROM cart_items WHERE id = ? AND session_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing delete query: " . $conn->error);
    }
    
    $stmt->bind_param("is", $cart_item_id, $session_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Error executing delete query: " . $stmt->error);
    }

    // Check if any row was actually deleted
    if ($stmt->affected_rows > 0) {
        $response = ['success' => true, 'message' => 'Item removed successfully.'];
    } else {
        // This could mean the item didn't exist or didn't belong to this session
        throw new Exception("Item not found or could not be removed."); 
    }
    
    $stmt->close();

} catch (Exception $e) {
    // Log the detailed error
    error_log("Error in remove_checkout_item.php: " . $e->getMessage() . "\nStack Trace:\n" . $e->getTraceAsString());
    
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