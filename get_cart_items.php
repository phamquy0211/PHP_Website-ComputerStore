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
    require_once 'db_connect.php';

    // Check if DB connection was successful
    if ($conn === null || $conn->connect_error) {
        throw new Exception("Database connection failed. Check server logs.");
    }

    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        if (!session_start()) {
            throw new Exception("Failed to start session.");
        }
    }

    $session_id = session_id();

    // Get cart items
    $sql = "SELECT * FROM cart_items WHERE session_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("s", $session_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Error executing statement: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $items = [];
    
    while ($row = $result->fetch_assoc()) {
        $items[] = [
            'id' => $row['id'],
            'product_id' => $row['product_id'],
            'name' => $row['product_name'],
            'price' => (float)$row['price'],
            'quantity' => (int)$row['quantity'], // Ensure integer
            'image' => $row['image_url'],
            'specs' => $row['specs']
        ];
    }
    $stmt->close();

    // Calculate totals
    $subtotal = 0;
    foreach ($items as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    $shipping = $subtotal > 50 ? 0 : 5.99;
    $tax = $subtotal * 0.06;
    $total = $subtotal + $shipping + $tax;

    // Set success response
    $response = [
        'success' => true,
        'items' => $items,
        'summary' => [
            // Format totals to 2 decimal places for consistency
            'subtotal' => round($subtotal, 2),
            'shipping' => round($shipping, 2),
            'tax' => round($tax, 2),
            'total' => round($total, 2)
        ]
    ];

} catch (Exception $e) {
    // Log the detailed error
    error_log("Error in get_cart_items.php: " . $e->getMessage() . "\nStack Trace:\n" . $e->getTraceAsString());
    
    // Set error response
    $response = [
        'success' => false,
        'message' => 'An error occurred while loading cart items.'
        // 'debug_error' => $e->getMessage() // Only for debugging
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