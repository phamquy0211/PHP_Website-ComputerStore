<?php
session_start();

// Include database connection
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: loginRegister.php");
    exit();
}

// Function to get user data
function getUserData($conn, $userId) {
    $stmt = $conn->prepare("SELECT fullname, email, gender, phone, date_of_birth, avatar FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    $stmt->close();
    return $userData;
}

// Get initial user data
$user = getUserData($conn, $_SESSION['user_id']);
$userFullname = $user['fullname'];
$userEmail = $user['email'];

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $fullname = trim(htmlspecialchars($_POST['fullname']));
    $gender = $_POST['gender'];
    $phone = trim(htmlspecialchars($_POST['phone']));
    $date_of_birth = $_POST['date_of_birth'];
    
    $profile_errors = [];
    
    // Handle avatar upload
    $avatar_path = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['avatar']['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (!in_array($filetype, $allowed)) {
            $profile_errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
        
        $max_size = 5 * 1024 * 1024; // 5MB
        if ($_FILES['avatar']['size'] > $max_size) {
            $profile_errors[] = "File size must be less than 5MB.";
        }
        
        if (empty($profile_errors)) {
            // Create uploads directory if it doesn't exist
            $upload_dir = 'uploads/avatars/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Generate unique filename
            $new_filename = uniqid('avatar_') . '.' . $filetype;
            $avatar_path = $upload_dir . $new_filename;
            
            // Move uploaded file
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path)) {
                // Get current avatar
                $stmt = $conn->prepare("SELECT avatar FROM users WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $current_user = $result->fetch_assoc();
                $stmt->close();

                // Delete old avatar if it exists and is not the default
                if (!empty($current_user['avatar']) && $current_user['avatar'] != 'default-avatar.png') {
                    $old_avatar = $upload_dir . $current_user['avatar'];
                    if (file_exists($old_avatar)) {
                        unlink($old_avatar);
                    }
                }
                $avatar_path = $new_filename;
            } else {
                $profile_errors[] = "Failed to upload image.";
                $avatar_path = null;
            }
        }
    }
    
    // Validate other inputs
    if (empty($fullname)) {
        $profile_errors[] = "Full name is required";
    }
    
    if (!empty($phone) && !preg_match('/^[0-9+\-() ]{10,20}$/', $phone)) {
        $profile_errors[] = "Invalid phone number format";
    }
    
    if (!empty($date_of_birth) && !strtotime($date_of_birth)) {
        $profile_errors[] = "Invalid date of birth";
    }
    
    if (empty($profile_errors)) {
        if ($avatar_path) {
            $stmt = $conn->prepare("UPDATE users SET fullname = ?, gender = ?, phone = ?, date_of_birth = ?, avatar = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $fullname, $gender, $phone, $date_of_birth, $avatar_path, $_SESSION['user_id']);
        } else {
            $stmt = $conn->prepare("UPDATE users SET fullname = ?, gender = ?, phone = ?, date_of_birth = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $fullname, $gender, $phone, $date_of_birth, $_SESSION['user_id']);
        }
        
        if ($stmt->execute()) {
            $profile_success = "Profile updated successfully!";
            $_SESSION['user_fullname'] = $fullname;
            
            // Refresh user data after successful update
            $user = getUserData($conn, $_SESSION['user_id']);
            $userFullname = $user['fullname'];
            $userEmail = $user['email'];
        } else {
            $profile_error = "Error updating profile: " . $conn->error;
        }
        $stmt->close();
    } else {
        $profile_error = implode('<br>', $profile_errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <title>TechHub - My Account</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
        background-color: #f5f5f5;
      }

      .navbar {
        background-color: #1a237e;
        color: white;
        padding: 1rem 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      }

      .navbar-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .logo {
        font-size: 1.8rem;
        font-weight: 700;
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
      }

      .logo span {
        color: #64b5f6;
      }

      .nav-links {
        list-style: none;
        display: flex;
        gap: 1.5rem;
      }

      .nav-links li {
        position: relative;
      }

      .nav-links a {
        color: white;
        text-decoration: none;
        font-size: 1rem;
        padding: 0.5rem 0;
        position: relative;
        transition: color 0.3s;
      }

      .nav-links a:hover {
        color: #64b5f6;
      }

      .nav-links a::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #64b5f6;
        transition: width 0.3s;
      }

      .nav-links a:hover::after {
        width: 100%;
      }

      .dropdown {
        position: relative;
      }

      .dropdown-content {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        min-width: 200px;
        z-index: 1;
        border-radius: 4px;
        padding: 0.5rem 0;
      }

      .dropdown:hover .dropdown-content {
        display: block;
      }

      .dropdown-content a {
        color: #333;
        padding: 0.5rem 1rem;
        display: block;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
      }

      .dropdown-content a:hover {
        background-color: #e3f2fd;
        color: #1a237e;
      }

      .dropdown-content a::after {
        display: none;
      }

      .icons {
        display: flex;
        gap: 1.5rem;
        align-items: center;
      }

      .icon {
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        transition: color 0.3s;
        position: relative;
      }

      .icon:hover {
        color: #64b5f6;
      }

      .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #f44336;
        color: white;
        font-size: 0.7rem;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .mobile-toggle {
        display: none;
        cursor: pointer;
        font-size: 1.5rem;
      }

      .nav-active {
        transform: translateX(0) !important;
      }

      /* Auth CTA Section Styles */
      .auth-cta-section {
        background-color: #f5f7ff;
        padding: 4rem 0;
        margin: 3rem 0;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      }

      .auth-cta-wrapper {
        display: flex;
        align-items: center;
        max-width: 1100px;
        margin: 0 auto;
        gap: 3rem;
      }

      .auth-cta-image {
        flex: 0 0 45%;
      }

      .auth-cta-image img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(74, 108, 247, 0.2);
      }

      .auth-cta-content {
        flex: 0 0 55%;
      }

      .auth-cta-content h2 {
        font-size: 2.2rem;
        color: #1a237e;
        margin-bottom: 1.2rem;
        line-height: 1.3;
      }

      .auth-cta-content p {
        color: #555;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
      }

      .auth-cta-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
      }

      .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.9rem 1.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .btn i {
        margin-right: 8px;
      }

      .btn-primary {
        background-color: #4a6cf7;
        color: white;
        border: 2px solid #4a6cf7;
      }

      .btn-primary:hover {
        background-color: #3a5bd9;
        border-color: #3a5bd9;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(74, 108, 247, 0.25);
      }

      .btn-outline {
        background-color: transparent;
        color: #4a6cf7;
        border: 2px solid #4a6cf7;
      }

      .btn-outline:hover {
        background-color: #f0f3ff;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(74, 108, 247, 0.15);
      }

      .auth-cta-benefits {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
      }

      .benefit-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .benefit-item i {
        font-size: 1.8rem;
        color: #4a6cf7;
        margin-bottom: 0.5rem;
      }

      .benefit-item span {
        font-size: 0.95rem;
        font-weight: 500;
        color: #444;
      }

      @media (max-width: 992px) {
        .auth-cta-wrapper {
          flex-direction: column;
          padding: 0 2rem;
        }

        .auth-cta-image,
        .auth-cta-content {
          flex: 0 0 100%;
        }

        .auth-cta-content h2 {
          font-size: 1.8rem;
        }
      }

      @media (max-width: 576px) {
        .auth-cta-buttons {
          flex-direction: column;
        }

        .auth-cta-benefits {
          flex-wrap: wrap;
          gap: 1.5rem;
          justify-content: center;
        }

        .benefit-item {
          width: 100%;
          max-width: 120px;
        }
      }

      /* Search Bar Styles */
      .search-container {
        position: relative;
        margin-right: 10px;
      }

      .search-bar {
        display: flex;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 4px;
        padding: 6px 12px;
        transition: all 0.3s ease;
      }

      .search-bar:focus-within {
        background-color: white;
      }

      .search-input {
        background: transparent;
        border: none;
        outline: none;
        color: white;
        width: 0;
        padding: 0;
        transition: all 0.3s ease;
      }

      .search-bar:focus-within .search-input {
        width: 200px;
        padding: 0 8px;
        color: #333;
      }

      .search-btn {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .search-bar:focus-within .search-btn {
        color: #1a237e;
      }

      /* Account Page Styles */
      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
      }

      .page-title {
        font-size: 2rem;
        color: #1a237e;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e0e0e0;
      }

      .account-wrapper {
        display: flex;
        gap: 2rem;
      }

      .account-sidebar {
        flex: 0 0 250px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
      }

      .user-info {
        text-align: center;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #e0e0e0;
      }

      .avatar-preview sidebar-avatar {
        width: 80px !important;
        height: 80px !important;
        margin: 0 auto 1rem;
        border-width: 3px;
      }

      .user-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
      }

      .user-email {
        font-size: 0.9rem;
        color: #666;
      }

      .sidebar-menu {
        list-style: none;
      }

      .sidebar-menu li {
        margin-bottom: 0.5rem;
      }

      .sidebar-menu a {
        display: flex;
        align-items: center;
        padding: 0.8rem 1rem;
        border-radius: 6px;
        color: #555;
        text-decoration: none;
        transition: all 0.3s;
      }

      .sidebar-menu a:hover {
        background-color: #f0f3ff;
        color: #4a6cf7;
      }

      .sidebar-menu a.active {
        background-color: #4a6cf7;
        color: white;
      }

      .sidebar-icon {
        margin-right: 0.8rem;
        font-size: 1.2rem;
      }

      .account-content {
        flex: 1;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 2rem;
      }

      .tab-content {
        display: none;
      }

      .tab-content.active {
        display: block;
      }

      .section-title {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 1.5rem;
      }

      .account-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
      }

      .account-card {
        background-color: #f8f9ff;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
      }

      .account-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
      }

      .card-title {
        display: flex;
        align-items: center;
        font-size: 1rem;
        color: #555;
        margin-bottom: 1rem;
      }

      .card-title span {
        font-size: 1.5rem;
        margin-right: 0.8rem;
      }

      .card-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a237e;
      }

      .order-list {
        width: 100%;
        border-collapse: collapse;
      }

      .order-list th,
      .order-list td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
      }

      .order-list th {
        font-weight: 600;
        color: #555;
        background-color: #f5f5f5;
      }

      .order-list tr:last-child td {
        border-bottom: none;
      }

      .order-status {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
      }

      .status-completed {
        background-color: #e8f5e9;
        color: #2e7d32;
      }

      .status-processing {
        background-color: #e3f2fd;
        color: #1565c0;
      }

      .status-pending {
        background-color: #fff8e1;
        color: #f57f17;
      }

      .status-cancelled {
        background-color: #ffebee;
        color: #c62828;
      }

      .btn-view {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        background-color: #f0f3ff;
        color: #4a6cf7;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s;
      }

      .btn-view:hover {
        background-color: #4a6cf7;
        color: white;
      }

      /* Responsive styles for account page */
      @media (max-width: 992px) {
        .account-wrapper {
          flex-direction: column;
        }

        .account-sidebar {
          flex: 0 0 100%;
        }
      }

      @media (max-width: 768px) {
        .account-cards {
          grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .order-list {
          font-size: 0.9rem;
        }

        .order-list th,
        .order-list td {
          padding: 0.8rem 0.5rem;
        }
      }

      @media (max-width: 576px) {
        .container {
          padding: 1rem;
        }

        .account-content {
          padding: 1.5rem 1rem;
        }

        .order-list {
          display: block;
          overflow-x: auto;
          white-space: nowrap;
        }
      }

      /* Notification Panel Styles */
      .notification-panel {
        position: fixed;
        top: 70px;
        right: -350px;
        width: 350px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        transition: right 0.3s ease;
        max-height: calc(100vh - 100px);
        display: flex;
        flex-direction: column;
      }

      .notification-panel.active {
        right: 20px;
      }

      .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
      }

      .notification-header h3 {
        font-size: 1.1rem;
        color: #333;
        margin: 0;
      }

      .mark-all-read {
        background: none;
        border: none;
        color: #4a6cf7;
        font-size: 0.9rem;
        cursor: pointer;
      }

      .notification-list {
        overflow-y: auto;
        padding: 10px 0;
        flex-grow: 1;
      }

      .notification-item {
        display: flex;
        padding: 12px 20px;
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s;
      }

      .notification-item:hover {
        background-color: #f9f9f9;
      }

      .notification-item.unread {
        background-color: #f0f7ff;
      }

      .notification-item.unread:hover {
        background-color: #e3f0ff;
      }

      .notification-content {
        flex-grow: 1;
      }

      .notification-content h4 {
        font-size: 0.95rem;
        margin: 0 0 5px 0;
        color: #333;
      }

      .notification-content p {
        font-size: 0.85rem;
        color: #666;
        margin: 0 0 5px 0;
      }

      .notification-time {
        font-size: 0.75rem;
        color: #999;
      }

      .notification-delete {
        background: none;
        border: none;
        color: #ccc;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0 0 0 10px;
        align-self: flex-start;
      }

      .notification-delete:hover {
        color: #f44336;
      }

      .notification-settings {
        padding: 12px 20px;
        border-top: 1px solid #eee;
        text-align: center;
      }

      .notification-settings a {
        color: #666;
        font-size: 0.85rem;
        text-decoration: none;
      }

      .notification-settings a:hover {
        color: #4a6cf7;
        text-decoration: underline;
      }

      .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
      }

      .overlay.active {
        display: block;
      }

      /* Modal Styles */
      .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1001;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
      }

      .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .modal-content {
        background-color: white;
        margin: auto;
        width: 90%;
        max-width: 450px;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        animation: modalFadeIn 0.3s;
      }

      @keyframes modalFadeIn {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #eee;
      }

      .modal-header h3 {
        margin: 0;
        color: #333;
        font-size: 1.2rem;
      }

      .close-modal {
        font-size: 1.5rem;
        font-weight: 700;
        color: #aaa;
        cursor: pointer;
        transition: color 0.3s;
      }

      .close-modal:hover {
        color: #333;
      }

      .modal-body {
        padding: 1.5rem;
      }

      .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
      }

      /* Alert Styles */
      .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 4px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        opacity: 1;
        transition: opacity 0.3s ease;
      }

      .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
      }

      .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
      }

      .alert .close {
        background: none;
        border: none;
        color: inherit;
        font-size: 1.25rem;
        padding: 0;
        margin-left: 1rem;
        opacity: 0.5;
        cursor: pointer;
        transition: opacity 0.15s;
      }

      .alert .close:hover {
        opacity: 1;
      }

      /* Remove margin from alert message */
      .alert p {
        margin: 0;
      }

      /* Modal Footer Button Styles */
      .modal-footer .btn-outline {
        padding: 0.6rem 1.2rem;
        border: 2px solid #4a6cf7;
        background: transparent;
        color: #4a6cf7;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .modal-footer .btn-outline:hover {
        background: #f0f3ff;
        transform: translateY(-2px);
      }

      .modal-footer .btn-primary {
        padding: 0.6rem 1.2rem;
        border: 2px solid #4a6cf7;
        background: #4a6cf7;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .modal-footer .btn-primary:hover {
        background: #3a5bd9;
        border-color: #3a5bd9;
        transform: translateY(-2px);
      }

      /* Avatar Styles */
      .avatar-upload {
        position: relative;
        max-width: 150px;
        margin: 0 auto 2rem;
      }

      .avatar-edit {
        position: absolute;
        right: 5px;
        z-index: 1;
        top: 5px;
      }

      .avatar-edit input {
        display: none;
      }

      .avatar-edit label {
        display: inline-block;
        width: 30px;
        height: 30px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #4a6cf7;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .avatar-edit label:hover {
        background: #3a5bd9;
      }

      .avatar-edit label i {
        color: #fff;
        font-size: 14px;
      }

      .avatar-preview {
        width: 150px;
        height: 150px;
        position: relative;
        border-radius: 100%;
        border: 4px solid #f8f8f8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
      }

      .avatar-preview > div {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
      }

      /* Orders Tab Styles */
      .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2rem;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      }

      .orders-table th,
      .orders-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #eee;
      }

      .orders-table th {
        background-color: #f8f9ff;
        font-weight: 600;
        color: #333;
      }

      .orders-table tr:hover {
        background-color: #f8f9ff;
      }

      .order-status {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        display: inline-block;
      }

      .status-processing {
        background-color: #e3f2fd;
        color: #1565c0;
      }

      .status-completed {
        background-color: #e8f5e9;
        color: #2e7d32;
      }

      .btn-view-details {
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        border: none;
        background-color: #4f46e5;
        color: white;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
      }

      .btn-view-details:hover {
        background-color: #4338ca;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
      }

      .btn-view-details:active {
        transform: translateY(0);
      }

      .details-row {
        background-color: #f8f9ff !important;
      }

      .order-details {
        display: none;
        margin: 1rem 0;
        padding: 1.5rem;
        background-color: #fff;
        border-radius: 8px;
      }

      .order-details.active {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(-10px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .order-details h4 {
        margin: 0 0 1rem 0;
        color: #333;
        font-size: 1.1rem;
      }

      .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
        background-color: #fff;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #eee;
      }

      .detail-item {
        padding: 0.5rem;
      }

      .detail-item strong {
        color: #666;
        display: block;
        margin-bottom: 0.3rem;
        font-size: 0.9rem;
      }

      .detail-item span {
        color: #333;
        font-size: 1rem;
      }

      .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        background-color: #fff;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #eee;
      }

      .items-table th,
      .items-table td {
        padding: 0.8rem;
        text-align: left;
        border-bottom: 1px solid #eee;
      }

      .items-table th {
        background-color: #f8f9ff;
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
      }

      .items-table tfoot tr:last-child {
        font-weight: 600;
        background-color: #f8f9ff;
      }

      .items-table tfoot td {
        padding: 1rem 0.8rem;
      }

      @media (max-width: 768px) {
        .orders-table {
          font-size: 0.9rem;
        }

        .order-status {
          padding: 0.3rem 0.6rem;
          font-size: 0.8rem;
        }

        .details-grid {
          grid-template-columns: 1fr;
        }

        .items-table {
          display: block;
          overflow-x: auto;
          white-space: nowrap;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php include "header.html"; ?>

    <!-- Logout Confirmation Modal -->
    <div class="modal" id="logout-modal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Confirm Logout</h3>
          <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to log out?</p>
        </div>
        <div class="modal-footer">
          <button class="btn-outline" id="cancel-logout">Cancel</button>
          <button class="btn-primary" id="confirm-logout">Logout</button>
        </div>
      </div>
    </div>

    <div class="container">
      <h1 class="page-title">My Account</h1>

      <div class="account-wrapper">
        <div class="account-sidebar">
          <div class="user-info">
            <div class="avatar-preview sidebar-avatar">
              <div style="background-image: url('<?php 
                $avatar = $user['avatar'] ?? 'default-avatar.png';
                echo 'uploads/avatars/' . htmlspecialchars($avatar);
              ?>')"></div>
            </div>
            <div class="user-name"><?php echo htmlspecialchars($userFullname); ?></div>
            <div class="user-email"><?php echo htmlspecialchars($userEmail); ?></div>
          </div>

          <ul class="sidebar-menu">
            <li>
              <a href="#" class="active" data-tab="dashboard">
                <span class="sidebar-icon">📊</span>
                Dashboard
              </a>
            </li>
            <li>
              <a href="#" data-tab="orders">
                <span class="sidebar-icon">📦</span>
                Orders
              </a>
            </li>
            <li>
              <a href="#" data-tab="wishlist">
                <span class="sidebar-icon">❤️</span>
                Wishlist
              </a>
            </li>
            <li>
              <a href="#" data-tab="addresses">
                <span class="sidebar-icon">📍</span>
                Addresses
              </a>
            </li>
            <li>
              <a href="#" data-tab="profile">
                <span class="sidebar-icon">👤</span>
                Profile Details
              </a>
            </li>
            <li>
              <a href="#" data-tab="security">
                <span class="sidebar-icon">🔒</span>
                Security
              </a>
            </li>
            <li>
              <a href="#" id="logout-link">
                <span class="sidebar-icon">🚪</span>
                Logout
              </a>
            </li>
          </ul>
        </div>

        <div class="account-content">
          <!-- Dashboard Tab -->
          <div class="tab-content active" id="dashboard">
            <h2 class="section-title">Dashboard</h2>

            <div class="account-cards">
              <div class="account-card">
                <div class="card-title">
                  <span>📦</span>
                  Total Orders
                </div>
                <div class="card-value">8</div>
              </div>

              <div class="account-card">
                <div class="card-title">
                  <span>⭐</span>
                  Reward Points
                </div>
                <div class="card-value">560</div>
              </div>

              <div class="account-card">
                <div class="card-title">
                  <span>💰</span>
                  Store Credit
                </div>
                <div class="card-value">$25.00</div>
              </div>
            </div>

            <h3 class="section-title">Recent Orders</h3>

            <table class="order-list">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>#TH80945</td>
                  <td>Feb 18, 2023</td>
                  <td>
                    <span class="order-status status-completed">Completed</span>
                  </td>
                  <td>$1,249.99</td>
                  <td><a href="#" class="btn-view">View</a></td>
                </tr>
                <tr>
                  <td>#TH80832</td>
                  <td>Jan 25, 2023</td>
                  <td>
                    <span class="order-status status-processing">Processing</span>
                  </td>
                  <td>$349.50</td>
                  <td><a href="#" class="btn-view">View</a></td>
                </tr>
                <tr>
                  <td>#TH80791</td>
                  <td>Jan 12, 2023</td>
                  <td>
                    <span class="order-status status-completed">Completed</span>
                  </td>
                  <td>$89.99</td>
                  <td><a href="#" class="btn-view">View</a></td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Orders Tab -->
          <div class="tab-content" id="orders">
            <h2 class="section-title">My Orders</h2>
            
            <?php
            // Get user's orders
            $stmt = $conn->prepare("
                SELECT o.*, 
                       DATE_FORMAT(o.created_at, '%M %d, %Y') as order_date
                FROM orders o 
                WHERE o.customer_id = ? OR o.session_id = ?
                ORDER BY o.created_at DESC
            ");
            $user_id = $_SESSION['user_id'];
            $current_session = session_id();
            $stmt->bind_param("is", $user_id, $current_session);
            $stmt->execute();
            $orders = $stmt->get_result();
            $stmt->close();

            if ($orders->num_rows > 0):
            ?>
            <table class="orders-table">
              <thead>
                <tr>
                  <th>Order Number</th>
                  <th>Order Date</th>
                  <th>Status</th>
                  <th>Total Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                  <td><?php echo $order['order_date']; ?></td>
                  <td>
                    <span class="order-status status-<?php echo strtolower($order['status']); ?>">
                      <?php echo htmlspecialchars($order['status']); ?>
                    </span>
                  </td>
                  <td>$<?php echo number_format($order['total'], 2); ?></td>
                  <td>
                    <button class="btn-view-details" onclick="toggleOrderDetails(<?php echo $order['id']; ?>)">
                      View Details
                    </button>
                  </td>
                </tr>
                <tr class="details-row">
                  <td colspan="5">
                    <div id="order-details-<?php echo $order['id']; ?>" class="order-details">
                      <h4>Order Details</h4>
                      <div class="details-grid">
                        <div class="detail-item">
                          <strong>Customer Name</strong>
                          <span><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></span>
                        </div>
                        <div class="detail-item">
                          <strong>Email</strong>
                          <span><?php echo htmlspecialchars($order['email']); ?></span>
                        </div>
                        <div class="detail-item">
                          <strong>Phone</strong>
                          <span><?php echo htmlspecialchars($order['phone']); ?></span>
                        </div>
                        <div class="detail-item">
                          <strong>Payment Method</strong>
                          <span><?php echo htmlspecialchars($order['payment_method']); ?></span>
                        </div>
                        <div class="detail-item">
                          <strong>Shipping Address</strong>
                          <span>
                            <?php 
                            echo htmlspecialchars($order['address']) . '<br>';
                            echo htmlspecialchars($order['city']) . ', ' . htmlspecialchars($order['state']) . ' ' . htmlspecialchars($order['zip_code']) . '<br>';
                            echo htmlspecialchars($order['country']);
                            ?>
                          </span>
                        </div>
                      </div>

                      <?php
                      // Get order items
                      $stmt = $conn->prepare("
                          SELECT * FROM order_items 
                          WHERE order_id = ?
                      ");
                      $stmt->bind_param("i", $order['id']);
                      $stmt->execute();
                      $items = $stmt->get_result();
                      $stmt->close();
                      ?>

                      <h4>Order Items</h4>
                      <table class="items-table">
                        <thead>
                          <tr>
                            <th>Product</th>
                            <th>Specifications</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($item = $items->fetch_assoc()): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['specs'] ?: 'N/A'); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                          </tr>
                          <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="4" style="text-align: right;"><strong>Subtotal:</strong></td>
                            <td>$<?php echo number_format($order['subtotal'], 2); ?></td>
                          </tr>
                          <tr>
                            <td colspan="4" style="text-align: right;"><strong>Shipping:</strong></td>
                            <td>$<?php echo number_format($order['shipping'], 2); ?></td>
                          </tr>
                          <tr>
                            <td colspan="4" style="text-align: right;"><strong>Tax:</strong></td>
                            <td>$<?php echo number_format($order['tax'], 2); ?></td>
                          </tr>
                          <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                            <td><strong>$<?php echo number_format($order['total'], 2); ?></strong></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-info">
              You haven't placed any orders yet.
            </div>
            <?php endif; ?>
          </div>

          <!-- Wishlist Tab -->
          <div class="tab-content" id="wishlist">
            <h2 class="section-title">My Wishlist</h2>
            <!-- Wishlist content here -->
          </div>

          <!-- Addresses Tab -->
          <div class="tab-content" id="addresses">
            <h2 class="section-title">My Addresses</h2>
            <!-- Addresses content here -->
          </div>

          <!-- Profile Tab -->
          <div class="tab-content" id="profile">
            <h2 class="section-title">Profile Details</h2>
            <?php
            // Get current user data including avatar
            $stmt = $conn->prepare("SELECT fullname, email, gender, phone, date_of_birth, avatar FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            ?>
            
            <?php if (isset($profile_success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $profile_success; ?>
                <button type="button" class="close" onclick="this.parentElement.style.display='none';">
                    <span>&times;</span>
                </button>
            </div>
            <?php endif; ?>
            
            <?php if (isset($profile_error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $profile_error; ?>
                <button type="button" class="close" onclick="this.parentElement.style.display='none';">
                    <span>&times;</span>
                </button>
            </div>
            <?php endif; ?>
            
            <form method="post" action="" enctype="multipart/form-data">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type="file" id="avatar" name="avatar" accept=".png, .jpg, .jpeg, .gif">
                        <label for="avatar">
                            <i class="fas fa-pencil-alt"></i>
                        </label>
                    </div>
                    <div class="avatar-preview">
                        <div id="imagePreview" style="background-image: url('<?php 
                            $avatar = $user['avatar'] ?? 'default-avatar.png';
                            echo 'uploads/avatars/' . htmlspecialchars($avatar);
                        ?>')"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    <small class="form-text text-muted">Email cannot be changed</small>
                </div>
                
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="male" <?php echo ($user['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo ($user['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?php echo ($user['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo $user['date_of_birth']; ?>">
                </div>
                
                <button type="submit" name="update_profile" class="btn btn-primary">
                    Save Changes
                </button>
            </form>
          </div>

          <!-- Security Tab -->
          <div class="tab-content" id="security">
            <h2 class="section-title">Security Settings</h2>
            <?php
            // Handle password change
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
                $current_password = $_POST['current_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                
                $security_errors = [];
                
                // Verify current password
                $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $user_data = $result->fetch_assoc();
                $stmt->close();
                
                if (!password_verify($current_password, $user_data['password'])) {
                    $security_errors[] = "Current password is incorrect";
                }
                
                if (strlen($new_password) < 8) {
                    $security_errors[] = "New password must be at least 8 characters long";
                }
                
                if ($new_password !== $confirm_password) {
                    $security_errors[] = "New passwords do not match";
                }
                
                if (empty($security_errors)) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);
                    
                    if ($stmt->execute()) {
                        $security_success = "Password changed successfully!";
                    } else {
                        $security_error = "Error changing password: " . $conn->error;
                    }
                    $stmt->close();
                } else {
                    $security_error = implode('<br>', $security_errors);
                }
            }
            ?>
            
            <?php if (isset($security_success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $security_success; ?>
                <button type="button" class="close" onclick="this.parentElement.style.display='none';">
                    <span>&times;</span>
                </button>
            </div>
            <?php endif; ?>
            
            <?php if (isset($security_error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $security_error; ?>
                <button type="button" class="close" onclick="this.parentElement.style.display='none';">
                    <span>&times;</span>
                </button>
            </div>
            <?php endif; ?>
            
            <form method="post" action="">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                    <small class="form-text text-muted">Password must be at least 8 characters long</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" name="change_password" class="btn btn-primary">
                    Save Changes
                </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>

    <!-- Back to top button -->
    <button id="back-to-top" class="back-to-top"><i class="fas fa-arrow-up"></i></button>

    <script>
      // Tab switching functionality
      document.addEventListener("DOMContentLoaded", function () {
        // Get shared elements
        const overlay = document.getElementById("overlay");

        // Logout functionality
        const logoutLink = document.getElementById("logout-link");
        const logoutModal = document.getElementById("logout-modal");
        const cancelLogout = document.getElementById("cancel-logout");
        const confirmLogout = document.getElementById("confirm-logout");
        const closeModal = document.querySelector(".close-modal");

        // Show logout confirmation modal
        logoutLink.addEventListener("click", function(e) {
          e.preventDefault();
          logoutModal.classList.add("active");
          overlay.classList.add("active");
        });

        // Hide modal when cancel is clicked
        cancelLogout.addEventListener("click", function() {
          logoutModal.classList.remove("active");
          overlay.classList.remove("active");
        });

        // Hide modal when X is clicked
        closeModal.addEventListener("click", function() {
          logoutModal.classList.remove("active");
          overlay.classList.remove("active");
        });

        // Proceed with logout when confirmed
        confirmLogout.addEventListener("click", function() {
          window.location.href = "logout.php";
        });

        // Tab switching functionality
        const tabLinks = document.querySelectorAll(".sidebar-menu a[data-tab]");
        const tabContents = document.querySelectorAll(".tab-content");

        tabLinks.forEach((link) => {
          link.addEventListener("click", function (e) {
            e.preventDefault();

            // Remove active class from all links and tabs
            tabLinks.forEach((l) => l.classList.remove("active"));
            tabContents.forEach((t) => t.classList.remove("active"));

            // Add active class to clicked link
            this.classList.add("active");

            // Show corresponding tab content
            const tabId = this.getAttribute("data-tab");
            document.getElementById(tabId).classList.add("active");
          });
        });

        // Notification panel toggle
        const notificationIcon = document.getElementById("notification-icon");
        const notificationPanel = document.getElementById("notification-panel");

        if (notificationIcon && notificationPanel) {
          notificationIcon.addEventListener("click", function () {
            notificationPanel.classList.toggle("active");
            overlay.classList.toggle("active");

            // Hide logout modal when notification panel is opened
            logoutModal.classList.remove("active");
          });
        }

        // Close all modals when overlay is clicked
        overlay.addEventListener("click", function () {
          if (notificationPanel) {
            notificationPanel.classList.remove("active");
          }
          logoutModal.classList.remove("active");
          overlay.classList.remove("active");
        });

        // Mark all notifications as read
        const markAllReadBtn = document.getElementById("mark-all-read");
        if (markAllReadBtn) {
          markAllReadBtn.addEventListener("click", function () {
            const unreadNotifications = document.querySelectorAll(
              ".notification-item.unread"
            );
            unreadNotifications.forEach((notification) => {
              notification.classList.remove("unread");
            });
            document.querySelector(".notification-count").textContent = "0";
          });
        }

        // Delete notification
        const deleteButtons = document.querySelectorAll(".notification-delete");
        deleteButtons.forEach((button) => {
          button.addEventListener("click", function () {
            const notification = this.closest(".notification-item");
            notification.style.height = "0";
            notification.style.opacity = "0";
            notification.style.padding = "0";
            notification.style.margin = "0";
            notification.style.overflow = "hidden";
            notification.style.transition = "all 0.3s ease";

            setTimeout(() => {
              notification.remove();
              updateNotificationCount();
            }, 300);
          });
        });

        function updateNotificationCount() {
          const unreadCount = document.querySelectorAll(
            ".notification-item.unread"
          ).length;
          document.querySelector(".notification-count").textContent = unreadCount;
        }

        // Auto-hide alerts after 10 seconds
        function setupAutoHideAlerts() {
          const alerts = document.querySelectorAll('.alert');
          alerts.forEach(alert => {
            setTimeout(() => {
              if (alert && alert.style.display !== 'none') {
                alert.style.display = 'none';
              }
            }, 10000); // 10 seconds
          });
        }

        // Call setupAutoHideAlerts when the page loads
        setupAutoHideAlerts();

        // Add fade out animation for alerts
        const closeButtons = document.querySelectorAll('.alert .close');
        closeButtons.forEach(button => {
          button.addEventListener('click', function() {
            const alert = this.parentElement;
            alert.style.opacity = '0';
            setTimeout(() => {
              alert.style.display = 'none';
            }, 300);
          });
        });

        // Avatar preview functionality
        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              document.getElementById('imagePreview').style.backgroundImage = 'url(' + e.target.result + ')';
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
        
        document.getElementById('avatar').addEventListener('change', function() {
          readURL(this);
        });

        // Add this to your existing JavaScript
        function toggleOrderDetails(orderId) {
          const detailsDiv = document.getElementById(`order-details-${orderId}`);
          const allDetails = document.querySelectorAll('.order-details');
          const button = event.currentTarget;
          
          // Close all other open details
          allDetails.forEach(detail => {
            if (detail.id !== `order-details-${orderId}`) {
              detail.classList.remove('active');
              const otherButton = detail.parentElement.parentElement.previousElementSibling.querySelector('.btn-view-details');
              if (otherButton) {
                otherButton.textContent = 'View Details';
              }
            }
          });
          
          // Toggle the clicked details
          detailsDiv.classList.toggle('active');
          
          // Update button text
          button.textContent = detailsDiv.classList.contains('active') ? 'Hide Details' : 'View Details';
        }
      });
    </script>
  </body>
</html>