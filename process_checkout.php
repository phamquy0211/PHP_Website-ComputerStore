<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    if (!isset($conn) || $conn === null || $conn->connect_error) {
        throw new Exception("Database connection failed. Please try again later.");
    }

    // Function to generate unique order number
    function generateOrderNumber() {
        return 'ORD' . time() . mt_rand(1000, 9999);
    }

    // Function to get cart items from database
    function getCartItems($conn) {
        $session_id = session_id();
        
        $sql = "SELECT * FROM cart_items WHERE session_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparing statement (getCartItems): " . $conn->error);
        }
        
        $stmt->bind_param("s", $session_id);
        if (!$stmt->execute()) {
            throw new Exception("Error executing statement (getCartItems): " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        $items = [];
        
        while ($row = $result->fetch_assoc()) {
            $items[] = [
                'product_id' => $row['product_id'],
                'product_name' => $row['product_name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'image_url' => $row['image_url'],
                'specs' => $row['specs']
            ];
        }
        $stmt->close();
        return $items;
    }

    // Function to calculate order totals
    function calculateOrderTotals($cartItems) {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $shipping = $subtotal > 50 ? 0 : 5.99;
        $taxRate = 0.06;
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $shipping + $tax;
        
        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total
        ];
    }

    // Process the checkout only if form is submitted via POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate required fields
    $required_fields = ['firstname', 'lastname', 'email', 'phone', 'address', 'city', 'state', 'country'];
    $missing_fields = [];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) { 
            $missing_fields[] = $field;
        }
    }
    if (!empty($missing_fields)) {
        throw new Exception('Missing required fields: ' . implode(', ', $missing_fields));
    }
    
    // Get form data and sanitize/validate
    $first_name = trim($_POST['firstname']);
    $last_name = trim($_POST['lastname']);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    if (!$email) { throw new Exception('Invalid email format'); }
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $country = trim($_POST['country']);
    $zip_code = trim($_POST['zip_code'] ?? '');
    $order_notes = trim($_POST['order_notes'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? 'credit_card');
    
    // Get cart items from database
    $cartItems = getCartItems($conn);
    
    if (empty($cartItems)) {
        throw new Exception('Your cart is empty. Cannot place order.');
    }
    
    // Calculate totals using the function
    $totals = calculateOrderTotals($cartItems);
    
    // Begin transaction
    if (!$conn->begin_transaction()) {
         throw new Exception("Failed to begin transaction: " . $conn->error);
    }
    
    try {
        // Generate unique order number
        $order_number = generateOrderNumber();

        // Insert order
        $stmt_order = $conn->prepare("INSERT INTO orders (
            order_number, session_id, first_name, last_name, email, phone, address, city, state, country,
            zip_code, order_notes, subtotal, shipping, tax, total, status, payment_method
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)");
        
        if (!$stmt_order) {
            throw new Exception("Error preparing order statement: " . $conn->error);
        }
        
        $session_id = session_id();
        
        // Bind parameters
        $stmt_order->bind_param("ssssssssssssdddss", 
            $order_number,
            $session_id,
            $first_name, $last_name, $email, $phone, $address, $city, $state, $country,
            $zip_code, $order_notes,
            $totals['subtotal'], $totals['shipping'], $totals['tax'], $totals['total'],
            $payment_method
        );
        
        if (!$stmt_order->execute()) {
            throw new Exception("Error executing order statement: " . $stmt_order->error);
        }
        
        $order_id = $conn->insert_id;
        $stmt_order->close();
        
        if ($order_id <= 0) {
             throw new Exception("Failed to get a valid Order ID after insertion.");
        }

        // Insert order items
        $stmt_items = $conn->prepare("INSERT INTO order_items (
            order_id, product_id, product_name, price, quantity, specs
        ) VALUES (?, ?, ?, ?, ?, ?)");
        
        if (!$stmt_items) {
            throw new Exception("Error preparing order items statement: " . $conn->error);
        }
        
        foreach ($cartItems as $item) {
            $product_id = (int)$item['product_id'];
            $product_name = trim($item['product_name']);
            $price = (float)$item['price'];
            $quantity = (int)$item['quantity'];
            $specs = $item['specs'];

            $stmt_items->bind_param("iisdis", 
                $order_id,
                $product_id, 
                $product_name, 
                $price, 
                $quantity,
                $specs
            );
            
            if (!$stmt_items->execute()) {
                throw new Exception("Error executing order items statement for product ID {$product_id}: " . $stmt_items->error);
            }
        }
        $stmt_items->close();
        
        // Clear cart items from database for this session
        $stmt_delete = $conn->prepare("DELETE FROM cart_items WHERE session_id = ?");
        if (!$stmt_delete) {
            throw new Exception("Error preparing delete cart statement: " . $conn->error);
        }
        
        $stmt_delete->bind_param("s", $session_id);
        if (!$stmt_delete->execute()) {
            throw new Exception("Error executing delete cart statement: " . $stmt_delete->error);
        }
        $stmt_delete->close();
        
        // Commit transaction
        if (!$conn->commit()) {
            throw new Exception("Failed to commit transaction: " . $conn->error);
        }
        
        // Set success response
        $response = [
            'success' => true,
            'order_id' => $order_id,
            'order_number' => $order_number,
            'message' => 'Order placed successfully!'
        ];
        
    } catch (Exception $e) {
        // Rollback transaction on error
        if ($conn && $conn->ping()) { 
             $conn->rollback();
        }
        throw $e;
    }
    
} catch (Exception $e) {
    error_log("Error in process_checkout.php: " . $e->getMessage());
    
    $response = [
        'success' => false,
        'message' => "Error processing order: " . $e->getMessage()
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

exit;
?> 