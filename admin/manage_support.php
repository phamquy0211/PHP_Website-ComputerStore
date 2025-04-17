<?php
// Include admin authentication check
include 'auth_check.php';
include '../db_connect.php';

// Check if database connection is established
if (!$conn) {
    die("Database connection failed. Please check the connection settings.");
}

// Function to get status color class
function getStatusColorClass($status) {
    switch ($status) {
        case 'Open':
            return 'danger';
        case 'In Progress':
            return 'warning';
        case 'Resolved':
            return 'success';
        case 'Closed':
            return 'secondary';
        default:
            return 'primary';
    }
}

// Update ticket status if form submitted
if (isset($_POST['update_status']) && isset($_POST['ticket_id']) && isset($_POST['status'])) {
    $ticket_id = intval($_POST['ticket_id']);
    $status = $conn->real_escape_string($_POST['status']);
    $admin_notes = $conn->real_escape_string($_POST['admin_notes']);
    
    $update_sql = "UPDATE support_tickets SET 
                    status = '$status', 
                    admin_notes = '$admin_notes',
                    updated_at = NOW() 
                  WHERE id = $ticket_id";
    
    if ($conn->query($update_sql)) {
        $statusMessage = "Ticket #$ticket_id updated successfully";
    } else {
        $errorMessage = "Error updating ticket: " . $conn->error;
    }
}

// Delete ticket if requested
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $ticket_id = intval($_GET['id']);
    
    $delete_sql = "DELETE FROM support_tickets WHERE id = $ticket_id";
    
    if ($conn->query($delete_sql)) {
        $statusMessage = "Ticket #$ticket_id deleted successfully";
    } else {
        $errorMessage = "Error deleting ticket: " . $conn->error;
    }
}

// Get ticket details if viewing a specific ticket
$ticket = null;
if (isset($_GET['view']) && isset($_GET['id'])) {
    $ticket_id = intval($_GET['id']);
    
    $ticket_sql = "SELECT * FROM support_tickets WHERE id = $ticket_id";
    $ticket_result = $conn->query($ticket_sql);
    
    if ($ticket_result && $ticket_result->num_rows > 0) {
        $ticket = $ticket_result->fetch_assoc();
    }
}

// Determine which view to show (list or detail)
$view_mode = isset($ticket) ? 'detail' : 'list';

// Get filter values if provided
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$priority_filter = isset($_GET['priority']) ? $_GET['priority'] : '';
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Build the SQL query with filters
$where_clauses = [];
if (!empty($status_filter)) {
    $status_filter = $conn->real_escape_string($status_filter);
    $where_clauses[] = "status = '$status_filter'";
}
if (!empty($category_filter)) {
    $category_filter = $conn->real_escape_string($category_filter);
    $where_clauses[] = "category = '$category_filter'";
}
if (!empty($priority_filter)) {
    $priority_filter = $conn->real_escape_string($priority_filter);
    $where_clauses[] = "priority = '$priority_filter'";
}
if (!empty($search_term)) {
    $search_term = $conn->real_escape_string($search_term);
    $where_clauses[] = "(name LIKE '%$search_term%' OR email LIKE '%$search_term%' OR subject LIKE '%$search_term%' OR message LIKE '%$search_term%')";
}

$where_sql = empty($where_clauses) ? "" : "WHERE " . implode(" AND ", $where_clauses);

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Count total tickets with filters
$count_sql = "SELECT COUNT(*) as total FROM support_tickets $where_sql";
$count_result = $conn->query($count_sql);
$total_tickets = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_tickets / $limit);

// Get tickets for current page
$tickets_sql = "SELECT * FROM support_tickets $where_sql ORDER BY created_at DESC LIMIT $offset, $limit";
$tickets_result = $conn->query($tickets_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Support Tickets - Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .ticket-filters {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .priority-badge {
            width: 100%;
            text-align: center;
        }
        .ticket-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .ticket-message {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            border-left: 5px solid #0d6efd;
            margin-bottom: 20px;
        }
        .admin-notes {
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 5px;
            border-left: 5px solid #28a745;
        }
        /* Sidebar Styles */
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
        
        .main-content {
            margin-left: 16.666667%; /* This matches the col-md-2 width */
            padding: 20px;
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
                margin-left: 70px !important;
            }
            
            .media-body h4, .media-body p {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar/Navigation would go here -->
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
                        <a href="manage_orders.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_support.php" class="nav-link active">
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
            
            <div class="col-md-10 main-content ml-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="page-title">Manage Support Tickets</h2>
                    <div class="btn-toolbar">
                        <?php if ($view_mode === 'detail'): ?>
                            <a href="manage_support.php" class="btn btn-outline-primary">
                                <i class="fas fa-list mr-2"></i>Back to Ticket List
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if (isset($statusMessage)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $statusMessage; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $errorMessage; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <?php if ($view_mode === 'list'): ?>
                    <!-- Ticket Filters -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Tickets</h5>
                            <span class="badge badge-light text-dark"><?php echo $total_tickets; ?> Total Tickets</span>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="manage_support.php" class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="status-filter">Status</label>
                                    <select name="status" id="status-filter" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="Open" <?php echo $status_filter === 'Open' ? 'selected' : ''; ?>>Open</option>
                                        <option value="In Progress" <?php echo $status_filter === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="Resolved" <?php echo $status_filter === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                        <option value="Closed" <?php echo $status_filter === 'Closed' ? 'selected' : ''; ?>>Closed</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="category-filter">Category</label>
                                    <select name="category" id="category-filter" class="form-control">
                                        <option value="">All Categories</option>
                                        <option value="order" <?php echo $category_filter === 'order' ? 'selected' : ''; ?>>Order Status & Shipping</option>
                                        <option value="returns" <?php echo $category_filter === 'returns' ? 'selected' : ''; ?>>Returns & Refunds</option>
                                        <option value="product" <?php echo $category_filter === 'product' ? 'selected' : ''; ?>>Product Information</option>
                                        <option value="technical" <?php echo $category_filter === 'technical' ? 'selected' : ''; ?>>Technical Support</option>
                                        <option value="account" <?php echo $category_filter === 'account' ? 'selected' : ''; ?>>Account Issues</option>
                                        <option value="other" <?php echo $category_filter === 'other' ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="priority-filter">Priority</label>
                                    <select name="priority" id="priority-filter" class="form-control">
                                        <option value="">All Priorities</option>
                                        <option value="normal" <?php echo $priority_filter === 'normal' ? 'selected' : ''; ?>>Normal</option>
                                        <option value="high" <?php echo $priority_filter === 'high' ? 'selected' : ''; ?>>High</option>
                                        <option value="urgent" <?php echo $priority_filter === 'urgent' ? 'selected' : ''; ?>>Urgent</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="search-filter">Search</label>
                                    <div class="input-group">
                                        <input type="text" name="search" id="search-filter" class="form-control" placeholder="Search tickets..." value="<?php echo htmlspecialchars($search_term); ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Tickets Table -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-ticket-alt mr-2"></i>Support Tickets</h5>
                            <div>
                                <a href="?status=Open" class="badge badge-danger mr-1">Open</a>
                                <a href="?status=In+Progress" class="badge badge-warning mr-1">In Progress</a>
                                <a href="?status=Resolved" class="badge badge-success mr-1">Resolved</a>
                                <a href="?status=Closed" class="badge badge-secondary">Closed</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>Customer</th>
                                            <th>Category</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($tickets_result && $tickets_result->num_rows > 0): ?>
                                            <?php while ($row = $tickets_result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                                    <td>
                                                        <?php echo htmlspecialchars($row['name']); ?><br>
                                                        <small class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $category_labels = [
                                                                'order' => 'Order Status & Shipping',
                                                                'returns' => 'Returns & Refunds',
                                                                'product' => 'Product Information',
                                                                'technical' => 'Technical Support',
                                                                'account' => 'Account Issues',
                                                                'other' => 'Other'
                                                            ];
                                                            echo isset($category_labels[$row['category']]) ? $category_labels[$row['category']] : $row['category'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $priority_badges = [
                                                                'normal' => '<span class="badge badge-success priority-badge">Normal</span>',
                                                                'high' => '<span class="badge badge-warning priority-badge">High</span>',
                                                                'urgent' => '<span class="badge badge-danger priority-badge">Urgent</span>'
                                                            ];
                                                            echo isset($priority_badges[$row['priority']]) ? $priority_badges[$row['priority']] : $row['priority'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-<?php echo getStatusColorClass($row['status']); ?>"><?php echo $row['status']; ?></span>
                                                    </td>
                                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                    <td>
                                                        <a href="manage_support.php?view=true&id=<?php echo $row['id']; ?>" class="btn btn-action btn-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="manage_support.php?delete=true&id=<?php echo $row['id']; ?>" class="btn btn-action btn-danger" onclick="return confirm('Are you sure you want to delete this ticket?');">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <i class="fas fa-ticket-alt mb-3" style="font-size: 3rem; color: #e2e8f0;"></i>
                                                    <h5>No support tickets found</h5>
                                                    <p class="text-muted">No tickets match your current filter criteria</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <nav aria-label="Page navigation" class="p-3">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="manage_support.php?page=<?php echo $page - 1; ?><?php echo !empty($status_filter) ? "&status=$status_filter" : ''; ?><?php echo !empty($category_filter) ? "&category=$category_filter" : ''; ?><?php echo !empty($priority_filter) ? "&priority=$priority_filter" : ''; ?><?php echo !empty($search_term) ? "&search=$search_term" : ''; ?>" aria-label="Previous">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                            <a class="page-link" href="manage_support.php?page=<?php echo $i; ?><?php echo !empty($status_filter) ? "&status=$status_filter" : ''; ?><?php echo !empty($category_filter) ? "&category=$category_filter" : ''; ?><?php echo !empty($priority_filter) ? "&priority=$priority_filter" : ''; ?><?php echo !empty($search_term) ? "&search=$search_term" : ''; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="manage_support.php?page=<?php echo $page + 1; ?><?php echo !empty($status_filter) ? "&status=$status_filter" : ''; ?><?php echo !empty($category_filter) ? "&category=$category_filter" : ''; ?><?php echo !empty($priority_filter) ? "&priority=$priority_filter" : ''; ?><?php echo !empty($search_term) ? "&search=$search_term" : ''; ?>" aria-label="Next">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                    
                <?php else: ?>
                    <!-- Ticket Detail View -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="fas fa-ticket-alt mr-2"></i>Ticket #<?php echo $ticket['id']; ?></h5>
                                    <span class="badge badge-<?php echo getStatusColorClass($ticket['status']); ?>"><?php echo $ticket['status']; ?></span>
                                </div>
                                <div class="card-body">
                                    <h4 class="font-weight-bold mb-3"><?php echo htmlspecialchars($ticket['subject']); ?></h4>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong><i class="fas fa-user mr-2"></i>Customer:</strong> <?php echo htmlspecialchars($ticket['name']); ?></p>
                                            <p class="mb-2"><strong><i class="fas fa-envelope mr-2"></i>Email:</strong> <?php echo htmlspecialchars($ticket['email']); ?></p>
                                            <?php if (!empty($ticket['order_number'])): ?>
                                                <p class="mb-2"><strong><i class="fas fa-shopping-cart mr-2"></i>Order Number:</strong> <?php echo htmlspecialchars($ticket['order_number']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2">
                                                <strong><i class="fas fa-tag mr-2"></i>Category:</strong> 
                                                <?php 
                                                    $category_labels = [
                                                        'order' => 'Order Status & Shipping',
                                                        'returns' => 'Returns & Refunds',
                                                        'product' => 'Product Information',
                                                        'technical' => 'Technical Support',
                                                        'account' => 'Account Issues',
                                                        'other' => 'Other'
                                                    ];
                                                    echo isset($category_labels[$ticket['category']]) ? $category_labels[$ticket['category']] : $ticket['category'];
                                                ?>
                                            </p>
                                            <p class="mb-2">
                                                <strong><i class="fas fa-flag mr-2"></i>Priority:</strong> 
                                                <?php 
                                                    $priority_badges = [
                                                        'normal' => '<span class="badge badge-success">Normal</span>',
                                                        'high' => '<span class="badge badge-warning">High</span>',
                                                        'urgent' => '<span class="badge badge-danger">Urgent</span>'
                                                    ];
                                                    echo isset($priority_badges[$ticket['priority']]) ? $priority_badges[$ticket['priority']] : $ticket['priority'];
                                                ?>
                                            </p>
                                            <p class="mb-2"><strong><i class="fas fa-calendar-alt mr-2"></i>Date Submitted:</strong> <?php echo date('F d, Y g:i A', strtotime($ticket['created_at'])); ?></p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="mt-4 mb-3"><i class="fas fa-comment mr-2"></i>Customer Message</h5>
                                    <div class="ticket-message">
                                        <?php echo nl2br(htmlspecialchars($ticket['message'])); ?>
                                    </div>
                                    
                                    <?php if (!empty($ticket['admin_notes'])): ?>
                                        <h5 class="mt-4 mb-3"><i class="fas fa-clipboard-list mr-2"></i>Admin Notes</h5>
                                        <div class="admin-notes">
                                            <?php echo nl2br(htmlspecialchars($ticket['admin_notes'])); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-edit mr-2"></i>Update Ticket</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="manage_support.php">
                                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                                        
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="Open" <?php echo $ticket['status'] === 'Open' ? 'selected' : ''; ?>>Open</option>
                                                <option value="In Progress" <?php echo $ticket['status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                                <option value="Resolved" <?php echo $ticket['status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                                <option value="Closed" <?php echo $ticket['status'] === 'Closed' ? 'selected' : ''; ?>>Closed</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="admin_notes">Admin Notes</label>
                                            <textarea name="admin_notes" id="admin_notes" class="form-control" rows="8"><?php echo htmlspecialchars($ticket['admin_notes'] ?? ''); ?></textarea>
                                        </div>
                                        
                                        <button type="submit" name="update_status" class="btn btn-primary btn-block">Update Ticket</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-cogs mr-2"></i>Actions</h5>
                                </div>
                                <div class="card-body">
                                    <a href="manage_support.php" class="btn btn-outline-secondary btn-block mb-2">
                                        <i class="fas fa-list mr-2"></i>Back to Ticket List
                                    </a>
                                    <a href="mailto:<?php echo htmlspecialchars($ticket['email']); ?>?subject=Re: <?php echo htmlspecialchars($ticket['subject']); ?>" class="btn btn-outline-primary btn-block mb-2">
                                        <i class="fas fa-envelope mr-2"></i>Email Customer
                                    </a>
                                    <a href="manage_support.php?delete=true&id=<?php echo $ticket['id']; ?>" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this ticket?');">
                                        <i class="fas fa-trash mr-2"></i>Delete Ticket
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
