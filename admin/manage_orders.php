<?php
require_once 'auth_check.php';
require_once '../db_connect.php';

// Check database connection
if (!isset($conn) || $conn === null || $conn->connect_error) {
    die("Database connection failed. Please try again later.");
}

// Get status filter if provided
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Prepare base query
$query = "SELECT o.*, 
          COUNT(oi.id) as item_count,
          CONCAT(o.first_name, ' ', o.last_name) as customer_name
          FROM orders o
          LEFT JOIN order_items oi ON o.id = oi.order_id";

// Add status filter if provided
if (!empty($status_filter)) {
    $query .= " WHERE o.status = ?";
}

// Add group by and order by
$query .= " GROUP BY o.id ORDER BY o.created_at DESC";

// Add limit for pagination
$query .= " LIMIT ?, ?";

// Prepare statement
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}

// Bind parameters based on whether we have a status filter
if (!empty($status_filter)) {
    $stmt->bind_param("sii", $status_filter, $offset, $per_page);
} else {
    $stmt->bind_param("ii", $offset, $per_page);
}

// Execute query
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get total orders count for pagination
$count_query = "SELECT COUNT(*) as total FROM orders";
if (!empty($status_filter)) {
    $count_query .= " WHERE status = ?";
    $count_stmt = $conn->prepare($count_query);
    if (!$count_stmt) {
        die("Error preparing count query: " . $conn->error);
    }
    $count_stmt->bind_param("s", $status_filter);
} else {
    $count_stmt = $conn->prepare($count_query);
    if (!$count_stmt) {
        die("Error preparing count query: " . $conn->error);
    }
}

$count_stmt->execute();
$total_result = $count_stmt->get_result();
$total_orders = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_orders / $per_page);
$count_stmt->close();

// Get counts by status for statistics
$status_counts = [];
$status_types = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];

foreach ($status_types as $status) {
    $status_stmt = $conn->prepare("SELECT COUNT(*) as count FROM orders WHERE status = ?");
    $status_stmt->bind_param("s", $status);
    $status_stmt->execute();
    $status_result = $status_stmt->get_result();
    $status_counts[$status] = $status_result->fetch_assoc()['count'];
    $status_stmt->close();
}

// Handle status update if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $update_stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if (!$update_stmt) {
        die("Error preparing update query: " . $conn->error);
    }
    $update_stmt->bind_param("si", $new_status, $order_id);
    
    if ($update_stmt->execute()) {
        $success_message = "Order #$order_id status updated to $new_status";
    } else {
        $error_message = "Failed to update order status: " . $conn->error;
    }
    $update_stmt->close();
    
    // Redirect to avoid form resubmission
    header("Location: manage_orders.php" . (!empty($status_filter) ? "?status=$status_filter" : ""));
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin Panel</title>
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
        
        .card-counter {
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            padding: 1.5rem;
            background-color: #fff;
            height: 140px;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .card-counter:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .card-counter:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(67, 97, 238, 0.3), rgba(76, 201, 240, 0.1));
            clip-path: circle(180px at 80% 20%);
            z-index: 0;
        }
        
        .card-counter .icon-container {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(67, 97, 238, 0.2);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card-counter .icon-container i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .card-counter .count-numbers {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.2rem;
            z-index: 1;
            position: relative;
        }
        
        .card-counter .count-name {
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            font-weight: 600;
            color: var(--text-muted);
            z-index: 1;
            position: relative;
        }
        
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-top: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.2rem 1.5rem;
            font-weight: 600;
            border: none;
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
        
        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            margin: 0 3px;
        }
        
        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        
        .btn-action.btn-primary {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border: none;
        }
        
        .btn-action.btn-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-action.btn-danger {
            background-color: rgba(230, 57, 70, 0.1);
            color: var(--danger-color);
            border: none;
        }
        
        .btn-action.btn-danger:hover {
            background-color: var(--danger-color);
            color: white;
        }
        
        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .filter-form {
            display: flex;
            align-items: center;
        }
        
        .filter-form label {
            margin-right: 10px;
            font-weight: 500;
            margin-bottom: 0;
        }
        
        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }
        
        .page-link {
            border: none;
            margin: 0 5px;
            border-radius: 8px;
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .page-link:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
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
                    <li class="nav-item">
                        <a href="manage_support.php" class="nav-link">
                            <i class="fas fa-headset"></i>
                            <span>Support</span>
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
                <h2 class="page-title">Manage Orders</h2>
                
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
                
                <!-- Order Statistics -->
                <div class="row mb-4">
                    <div class="col-md">
                        <div class="card-counter">
                            <div class="count-numbers"><?php echo $total_orders; ?></div>
                            <div class="count-name">Total Orders</div>
                            <div class="icon-container">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md">
                        <div class="card-counter">
                            <div class="count-numbers"><?php echo $status_counts['Pending']; ?></div>
                            <div class="count-name">Pending</div>
                            <div class="icon-container">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md">
                        <div class="card-counter">
                            <div class="count-numbers"><?php echo $status_counts['Processing']; ?></div>
                            <div class="count-name">Processing</div>
                            <div class="icon-container">
                                <i class="fas fa-cogs"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md">
                        <div class="card-counter">
                            <div class="count-numbers"><?php echo $status_counts['Delivered']; ?></div>
                            <div class="count-name">Delivered</div>
                            <div class="icon-container">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-list mr-2"></i>Order List</h5>
                        <div class="filter-form">
                            <form method="get" class="d-flex align-items-center">
                                <label for="status">Filter by:</label>
                                <select name="status" id="status" class="form-control ml-2" onchange="this.form.submit()">
                                    <option value="">All Orders</option>
                                    <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Processing" <?php echo $status_filter === 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                    <option value="Shipped" <?php echo $status_filter === 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                    <option value="Delivered" <?php echo $status_filter === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                    <option value="Cancelled" <?php echo $status_filter === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <?php if (empty($orders)): ?>
                            <div class="p-4 text-center">
                                <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                                <p class="text-muted">No orders found.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td>
                                                    <div class="font-weight-medium"><?php echo htmlspecialchars($order['order_number']); ?></div>
                                                </td>
                                                <td>
                                                    <span class="date-badge">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                                <td><?php echo (int)$order['item_count']; ?> items</td>
                                                <td>
                                                    <div class="font-weight-bold">$<?php echo number_format($order['total'], 2); ?></div>
                                                </td>
                                                <td>
                                                    <?php
                                                        $status_class = 'status-' . strtolower($order['status']);
                                                        echo '<span class="status-badge ' . $status_class . '">' . htmlspecialchars($order['status']) . '</span>';
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="view_order.php?id=<?php echo $order['id']; ?>" class="btn btn-action btn-primary" title="View Order">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-action btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-<?php echo $order['id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Update Status">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-<?php echo $order['id']; ?>">
                                                            <?php foreach(['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'] as $status): ?>
                                                                <form method="post" class="dropdown-item" onsubmit="return confirm('Are you sure you want to change the status to <?php echo $status; ?>?');">
                                                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                                                    <input type="hidden" name="new_status" value="<?php echo $status; ?>">
                                                                    <button type="submit" class="btn btn-link p-0">
                                                                        <?php echo $status; ?>
                                                                    </button>
                                                                </form>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="card-footer pb-0">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo !empty($status_filter) ? '&status=' . $status_filter : ''; ?>" aria-label="Previous">
                                                    <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($status_filter) ? '&status=' . $status_filter : ''; ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo !empty($status_filter) ? '&status=' . $status_filter : ''; ?>" aria-label="Next">
                                                    <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
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
