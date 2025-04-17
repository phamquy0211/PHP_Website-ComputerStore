<?php
// Initialize session at the beginning
session_start();

// Include database connection
include 'db_connect.php';

// Check if database connection is established
if (!$conn) {
    $_SESSION['support_errors'] = ['Database connection failed. Please try again later or contact the administrator.'];
    $_SESSION['form_data'] = $_POST; // Store form data for repopulating the form
    header("Location: support.php?error=1#ticket-section");
    exit();
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    $required_fields = ['name', 'email', 'subject', 'category', 'priority', 'message'];
    $errors = [];
    
    // Check required fields
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . ' is required';
        }
    }
    
    // Validate email
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }
    
    if (empty($errors)) {
        // Sanitize input data
        $name = $conn->real_escape_string(trim($_POST['name']));
        $email = $conn->real_escape_string(trim($_POST['email']));
        $order_number = !empty($_POST['order_number']) ? $conn->real_escape_string(trim($_POST['order_number'])) : null;
        $subject = $conn->real_escape_string(trim($_POST['subject']));
        $category = $conn->real_escape_string(trim($_POST['category']));
        $priority = $conn->real_escape_string(trim($_POST['priority']));
        $message = $conn->real_escape_string(trim($_POST['message']));
        
        // Insert into support_tickets table
        $sql = "INSERT INTO support_tickets (name, email, order_number, subject, category, priority, message, status) 
                VALUES ('$name', '$email', " . ($order_number ? "'$order_number'" : "NULL") . ", '$subject', '$category', '$priority', '$message', 'Open')";
        
        if ($conn->query($sql)) {
            $_SESSION['support_success'] = true;
            header("Location: support.php?success=1#ticket-section");
            exit();
        } else {
            $errors[] = "Failed to submit support ticket: " . $conn->error;
        }
    }
    
    // If we have errors, store them in session and redirect back to the form
    if (!empty($errors)) {
        $_SESSION['support_errors'] = $errors;
        $_SESSION['form_data'] = $_POST; // Store form data for repopulating the form
        header("Location: support.php?error=1#ticket-section");
        exit();
    }
} else {
    // Redirect to the support page if accessed directly
    header("Location: support.php");
    exit();
}
?> 