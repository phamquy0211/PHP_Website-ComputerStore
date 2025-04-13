<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Store session_id right after starting the session
$current_session_id = session_id();
if (empty($current_session_id)) {
    throw new Exception("Invalid session. Please try again.");
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
        return 'ORD' . str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
    }

    // Function to get cart items from database
    function getCartItems($conn) {
        global $current_session_id; // Add this line to use the global session ID
        
        $sql = "SELECT * FROM cart_items WHERE session_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparing statement (getCartItems): " . $conn->error);
        }
        
        $stmt->bind_param("s", $current_session_id);
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

    // Log the received POST data for debugging
    error_log("Received POST data: " . print_r($_POST, true));

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
    
    // Debug log cart items
    error_log("Cart Items: " . print_r($cartItems, true));
    
    if (empty($cartItems)) {
        throw new Exception('Your cart is empty. Cannot place order.');
    }
    
    // Calculate totals using the function
    $totals = calculateOrderTotals($cartItems);
    
    // Start transaction for the entire checkout process
    $conn->begin_transaction();
    
    // Validate data lengths and formats
    $validation_errors = [];
    
    // Validate personal information
    if (strlen($first_name) > 100) $validation_errors[] = "First name is too long (maximum 100 characters)";
    if (strlen($last_name) > 100) $validation_errors[] = "Last name is too long (maximum 100 characters)";
    if (strlen($email) > 100) $validation_errors[] = "Email is too long (maximum 100 characters)";
    if (strlen($phone) > 20) $validation_errors[] = "Phone number is too long (maximum 20 characters)";
    
    // Validate address information
    if (strlen($address) > 255) $validation_errors[] = "Address is too long (maximum 255 characters)";
    if (strlen($city) > 100) $validation_errors[] = "City name is too long (maximum 100 characters)";
    if (strlen($state) > 100) $validation_errors[] = "State name is too long (maximum 100 characters)";
    if (strlen($country) > 100) $validation_errors[] = "Country name is too long (maximum 100 characters)";
    
    // Validate cart and totals
    if ($totals['subtotal'] < 0) $validation_errors[] = "Invalid subtotal amount";
    if ($totals['shipping'] < 0) $validation_errors[] = "Invalid shipping amount";
    if ($totals['tax'] < 0) $validation_errors[] = "Invalid tax amount";
    if ($totals['total'] < 0) $validation_errors[] = "Invalid total amount";
    
    // Check product availability and validate quantities
    $unavailable_products = [];
    foreach ($cartItems as $item) {
        // Validate product exists and check price
        $stmt = $conn->prepare("SELECT id, regular_price FROM products WHERE id = ?");
        $stmt->bind_param("i", $item['product_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $unavailable_products[] = "Product '{$item['product_name']}' is no longer available";
        } else {
            $product = $result->fetch_assoc();
            
            // Verify price hasn't changed
            if (abs($product['regular_price'] - $item['price']) > 0.01) { // Using 0.01 for floating point comparison
                $validation_errors[] = "Price for '{$item['product_name']}' has changed. Please refresh your cart.";
            }
        }
    }
    
    // If we have any validation errors, throw them
    if (!empty($validation_errors) || !empty($unavailable_products)) {
        throw new Exception(implode("\n", array_merge($validation_errors, $unavailable_products)));
    }

    // Backup cart items in case we need to restore them
    $cart_backup = $cartItems;

    // Process customer creation/update
    $customer_id = null;
    
    // First, check if the email exists in customers table
    $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ? LIMIT 1");
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Customer exists - update their information
        $row = $result->fetch_assoc();
        $customer_id = $row['id'];
        
        $stmt = $conn->prepare("UPDATE customers SET 
            first_name = ?, 
            last_name = ?, 
            phone = ?,
            address = ?,
            city = ?,
            state = ?,
            country = ?
            WHERE id = ?");
        
        if (!$stmt) {
            throw new Exception("Error preparing customer update: " . $conn->error);
        }
        
        $stmt->bind_param("sssssssi", 
            $first_name, 
            $last_name, 
            $phone,
            $address,
            $city,
            $state,
            $country,
            $customer_id
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Could not update customer: " . $stmt->error);
        }
    } else {
        // Create new customer
        $stmt = $conn->prepare("INSERT INTO customers (
            first_name, 
            last_name, 
            email, 
            phone,
            address,
            city,
            state,
            country
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            throw new Exception("Error preparing customer insert: " . $conn->error);
        }
        
        $stmt->bind_param("ssssssss", 
            $first_name, 
            $last_name, 
            $email, 
            $phone,
            $address,
            $city,
            $state,
            $country
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Could not create customer: " . $stmt->error);
        }
        $customer_id = $stmt->insert_id;
    }

    // Create the order
    $order_number = generateOrderNumber();
    // Use the stored session ID instead
    $status = 'Processing';
    
    // Insert the order
    $stmt = $conn->prepare("INSERT INTO orders (
        order_number, customer_id, session_id, first_name, last_name, 
        email, phone, address, city, state, country, zip_code, 
        order_notes, subtotal, shipping, tax, total, status, payment_method
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        throw new Exception("Error preparing order statement: " . $conn->error);
    }
    
    $stmt->bind_param("sisssssssssssddddss",
        $order_number,
        $customer_id,
        $current_session_id,  // Use the stored session ID
        $first_name, $last_name, $email, $phone,
        $address, $city, $state, $country, $zip_code,
        $order_notes,
        $totals['subtotal'], $totals['shipping'], $totals['tax'], $totals['total'],
        $status,
        $payment_method
    );
    
    if (!$stmt->execute()) {
        throw new Exception("Could not create order: " . $stmt->error);
    }
    
    $order_id = $stmt->insert_id;
    
    // Insert order items (without stock updates for now)
    foreach ($cartItems as $item) {
        // Insert order item
        $stmt = $conn->prepare("INSERT INTO order_items (
            order_id, product_id, product_name, price, quantity, specs
        ) VALUES (?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("iisdis",
            $order_id,
            $item['product_id'],
            $item['product_name'],
            $item['price'],
            $item['quantity'],
            $item['specs']
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Could not create order item: " . $stmt->error);
        }
    }
    
    // Clear the cart
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE session_id = ?");
    if (!$stmt) {
        throw new Exception("Error preparing cart clear statement: " . $conn->error);
    }
    
    $stmt->bind_param("s", $current_session_id);  // Use the stored session ID
    
    if (!$stmt->execute()) {
        throw new Exception("Could not clear cart: " . $stmt->error);
    }
    
    // If we get here, everything worked! Commit the transaction
    $conn->commit();
    
    // Return success response
    $response = [
        'success' => true,
        'order_id' => $order_id,
        'order_number' => $order_number,
        'message' => 'Order placed successfully'
    ];

} catch (Exception $e) {
    // Rollback transaction on any error
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->rollback();
    }
    
    // Log the detailed error
    error_log("Checkout Error: " . $e->getMessage());
    error_log("Error trace: " . $e->getTraceAsString());
    
    // If we have a cart backup and the error wasn't during cart clearing
    if (isset($cart_backup) && strpos($e->getMessage(), "Could not clear cart") === false) {
        // Restore cart items
        foreach ($cart_backup as $item) {
            $stmt = $conn->prepare("INSERT INTO cart_items (
                session_id, product_id, product_name, price, quantity, image_url, specs
            ) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->bind_param("sisdiss",
                $current_session_id,  // Use the stored session ID
                $item['product_id'],
                $item['product_name'],
                $item['price'],
                $item['quantity'],
                $item['image_url'],
                $item['specs']
            );
            
            $stmt->execute();
        }
    }
    
    $response = [
        'success' => false,
        'message' => "Error details: " . $e->getMessage(),
        'debug_info' => [
            'error_type' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ];
}

// Clean the output buffer before sending JSON
ob_end_clean();

// Log the response being sent
error_log("Sending response: " . json_encode($response));

// Send the JSON response
echo json_encode($response);

// Close database connection if it was opened
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}

exit;
?> 