<?php
session_start();
require_once 'db_connect.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check database connection
if (!isset($conn) || $conn === null || $conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed. Please try again later.'
    ]);
    exit;
}

// Function to generate unique order number
function generateOrderNumber() {
    return 'ORD' . time() . mt_rand(1000, 9999);
}

try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        throw new Exception("Invalid request data");
    }

    // Validate required fields
    $required_fields = ['customer', 'items', 'subtotal', 'shipping', 'tax', 'total'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Start transaction
    if (!$conn->begin_transaction()) {
        throw new Exception("Failed to begin transaction");
    }

    // Generate unique order number
    $order_number = generateOrderNumber();

    // Create order
    $order_sql = "INSERT INTO orders (
        order_number, session_id, 
        first_name, last_name, email, phone, address, city, state, country,
        subtotal, shipping, tax, total, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";

    $stmt = $conn->prepare($order_sql);
    if (!$stmt) {
        throw new Exception("Error preparing order statement: " . $conn->error);
    }

    $session_id = session_id();
    $customer = $data['customer'];
    
    $stmt->bind_param(
        "ssssssssssdddd",
        $order_number,
        $session_id,
        $customer['firstName'],
        $customer['lastName'],
        $customer['email'],
        $customer['phone'],
        $customer['address'],
        $customer['city'],
        $customer['state'],
        $customer['country'],
        $data['subtotal'],
        $data['shipping'],
        $data['tax'],
        $data['total']
    );

    if (!$stmt->execute()) {
        throw new Exception("Error creating order: " . $stmt->error);
    }

    $order_id = $stmt->insert_id;
    $stmt->close();

    if ($order_id <= 0) {
        throw new Exception("Failed to get a valid Order ID after insertion");
    }

    // Insert order items
    $item_sql = "INSERT INTO order_items (
        order_id, product_id, product_name, price, quantity, specs
    ) VALUES (?, ?, ?, ?, ?, ?)";
    
    $item_stmt = $conn->prepare($item_sql);
    if (!$item_stmt) {
        throw new Exception("Error preparing order items statement: " . $conn->error);
    }

    foreach ($data['items'] as $item) {
        $specs = isset($item['specs']) ? json_encode($item['specs']) : null;
        $item_stmt->bind_param(
            "iisdis",
            $order_id,
            $item['id'],
            $item['name'],
            $item['price'],
            $item['quantity'],
            $specs
        );
        
        if (!$item_stmt->execute()) {
            throw new Exception("Error adding order item: " . $item_stmt->error);
        }
    }

    $item_stmt->close();

    // Clear cart
    $clear_cart = $conn->prepare("DELETE FROM cart_items WHERE session_id = ?");
    if (!$clear_cart) {
        throw new Exception("Error preparing clear cart statement: " . $conn->error);
    }

    $clear_cart->bind_param("s", $session_id);
    if (!$clear_cart->execute()) {
        throw new Exception("Error clearing cart: " . $clear_cart->error);
    }
    $clear_cart->close();

    // Commit transaction
    if (!$conn->commit()) {
        throw new Exception("Failed to commit transaction");
    }

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully!',
        'order_id' => $order_id,
        'order_number' => $order_number
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if ($conn && !$conn->connect_error) {
        $conn->rollback();
    }
    
    echo json_encode([
        'success' => false,
        'message' => 'Error saving order: ' . $e->getMessage()
    ]);
}

// Close connection
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>