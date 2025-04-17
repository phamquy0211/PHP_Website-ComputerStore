<?php
require_once 'auth_check.php';
require_once '../db_connect.php';

// Check database connection
if (!isset($conn) || $conn === null || $conn->connect_error) {
    die("Database connection failed. Please try again later.");
}

// Check if order ID is provided
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    header('Location: manage_orders.php');
    exit;
}

$order_id = (int)$_GET['id'];

// Get order details
$stmt = $conn->prepare("
    SELECT * FROM orders
    WHERE id = ?
");
if (!$stmt) {
    die("Error preparing order query: " . $conn->error);
}

$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: manage_orders.php');
    exit;
}

$order = $result->fetch_assoc();
$stmt->close();

// Get order items
$stmt = $conn->prepare("
    SELECT oi.*, p.image 
    FROM order_items oi
    LEFT JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
if (!$stmt) {
    die("Error preparing order items query: " . $conn->error);
}

$stmt->bind_param("i", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();
$items = $items_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Calculate totals
$item_count = count($items);
$subtotal = $order['subtotal'];
$shipping = $order['shipping'];
$tax = $order['tax'];
$total = $order['total'];

// Handle status update if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_status'])) {
    $new_status = $_POST['new_status'];
    
    $update_stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if (!$update_stmt) {
        die("Error preparing update query: " . $conn->error);
    }
    $update_stmt->bind_param("si", $new_status, $order_id);
    
    if ($update_stmt->execute()) {
        $success_message = "Order status updated to $new_status";
        // Update the order variable to reflect the change
        $order['status'] = $new_status;
    } else {
        $error_message = "Failed to update order status: " . $conn->error;
    }
    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?php echo $order['order_number']; ?> - Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --success-color: #2ecc71;
            --danger-color: #e63946;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --text-muted: #6c757d;
        }
        
        body {
            background-color: #f1f5f9;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        .sidebar {
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            position: fixed;
            left: 0;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .sidebar .brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 20px;
            margin: 8px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }
        
        .page-title {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .page-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 4px;
            width: 50px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.2rem 1.5rem;
            font-weight: 600;
            border: none;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: rgba(255, 193, 7, 0.2);
            color: #d39e00;
        }
        
        .status-processing {
            background-color: rgba(33, 150, 243, 0.2);
            color: #0b7dda;
        }
        
        .status-shipped {
            background-color: rgba(156, 39, 176, 0.2);
            color: #7b1fa2;
        }
        
        .status-delivered {
            background-color: rgba(46, 204, 113, 0.2);
            color: #25a25a;
        }
        
        .status-cancelled {
            background-color: rgba(230, 57, 70, 0.2);
            color: #c62828;
        }
        
        .info-group {
            margin-bottom: 20px;
        }
        
        .info-group h5 {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: 500;
            color: var(--text-muted);
            min-width: 140px;
        }
        
        .info-value {
            color: var(--dark-color);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            color: var(--dark-color);
            font-weight: 600;
            border: none;
            padding: 1rem 1.5rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-color: #f1f5f9;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }
        
        .order-totals {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        
        .grand-total {
            font-weight: 700;
            font-size: 18px;
            padding-top: 10px;
            margin-top: 10px;
            border-top: 2px solid #dee2e6;
            color: var(--primary-color);
        }
        
        .success-message {
            background-color: rgba(46, 204, 113, 0.2);
            color: #25a25a;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .error-message {
            background-color: rgba(230, 57, 70, 0.2);
            color: #c62828;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar .brand {
                padding: 1rem 0.5rem;
                text-align: center;
            }
            
            .sidebar .nav-link {
                padding: 15px 0;
                text-align: center;
                margin: 5px;
            }
            
            .sidebar .nav-link i {
                margin: 0;
                font-size: 1.3rem;
            }
            
            .sidebar .nav-link span {
                display: none;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="brand py-4 px-4 mb-2">
                    <div class="media d-flex align-items-center">
                        <i class="fas fa-laptop-code mr-2" style="font-size: 1.8rem;"></i>
                        <div class="media-body">
                            <h4 class="m-0">TechHub</h4>
                            <p class="font-weight-light text-white-50 mb-0">Admin Panel</p>
                        </div>
                    </div>
                </div>
                <ul class="nav flex-column px-3">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_users.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_products.php" class="nav-link">
                            <i class="fas fa-laptop"></i>
                            <span>Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_orders.php" class="nav-link active">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <a href="../logout.php" class="nav-link text-danger">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="page-title">Order Details</h2>
                    <a href="manage_orders.php" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Orders
                    </a>
                </div>
                
                <?php if (isset($success_message)): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle mr-2"></i>
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error_message)): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Order Summary -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Order #<?php echo htmlspecialchars($order['order_number']); ?>
                        </h5>
                        <span class="status-badge status-<?php echo strtolower($order['status']); ?>">
                            <?php echo htmlspecialchars($order['status']); ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-group">
                                    <h5><i class="fas fa-info-circle mr-2"></i>Order Information</h5>
                                    <div class="info-row">
                                        <span class="info-label">Order Number:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['order_number']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Date:</span>
                                        <span class="info-value"><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Items:</span>
                                        <span class="info-value"><?php echo $item_count; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Total:</span>
                                        <span class="info-value font-weight-bold">$<?php echo number_format($total, 2); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="info-group">
                                    <h5><i class="fas fa-user mr-2"></i>Customer Information</h5>
                                    <div class="info-row">
                                        <span class="info-label">Name:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Email:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['email']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Phone:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['phone']); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="info-group">
                                    <h5><i class="fas fa-shipping-fast mr-2"></i>Shipping Address</h5>
                                    <div class="info-row">
                                        <span class="info-value"><?php echo htmlspecialchars($order['address']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-value"><?php echo htmlspecialchars($order['city'] . ', ' . $order['state']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-value"><?php echo htmlspecialchars($order['country']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Status -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sync-alt mr-2"></i>Update Order Status</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" class="form-inline" onsubmit="return confirm('Are you sure you want to update this order status?');">
                            <label for="new_status" class="mr-2">New Status:</label>
                            <select name="new_status" id="new_status" class="form-control mr-3">
                                <option value="Pending" <?php echo $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?php echo $order['status'] === 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="Shipped" <?php echo $order['status'] === 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo $order['status'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
                
                <!-- Order Items -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-box-open mr-2"></i>Order Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="70">Image</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="../<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="item-image">
                                                <?php else: ?>
                                                    <div class="no-image text-center bg-light p-2 rounded" style="width:50px;height:50px">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="font-weight-medium"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                                <?php if (!empty($item['specs'])): ?>
                                                    <div class="mt-1">
                                                        <?php
                                                            $specs = json_decode($item['specs'], true);
                                                            if (is_array($specs)) {
                                                                echo '<small class="text-muted">';
                                                                $spec_strings = [];
                                                                foreach ($specs as $key => $value) {
                                                                    $spec_strings[] = htmlspecialchars($key) . ': ' . htmlspecialchars($value);
                                                                }
                                                                echo implode(' | ', $spec_strings);
                                                                echo '</small>';
                                                            }
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                                            <td><?php echo (int)$item['quantity']; ?></td>
                                            <td class="font-weight-bold">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 ml-auto">
                                    <div class="order-totals">
                                        <div class="total-row">
                                            <span>Subtotal:</span>
                                            <span>$<?php echo number_format($subtotal, 2); ?></span>
                                        </div>
                                        <div class="total-row">
                                            <span>Shipping:</span>
                                            <span>$<?php echo number_format($shipping, 2); ?></span>
                                        </div>
                                        <div class="total-row">
                                            <span>Tax:</span>
                                            <span>$<?php echo number_format($tax, 2); ?></span>
                                        </div>
                                        <div class="total-row grand-total">
                                            <span>Total:</span>
                                            <span>$<?php echo number_format($total, 2); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 