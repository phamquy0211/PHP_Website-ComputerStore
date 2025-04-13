<?php
session_start();
require_once 'db_connect.php';

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit();
}

$order_id = (int)$_GET['order_id'];

// Get order details
$stmt = $conn->prepare("
    SELECT o.*, DATE_FORMAT(o.created_at, '%M %d, %Y') as formatted_date
    FROM orders o 
    WHERE o.id = ? AND (o.customer_id = ? OR o.session_id = ?)
");

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$session_id = session_id();
$stmt->bind_param("iis", $order_id, $user_id, $session_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

// If order not found or doesn't belong to current user/session, redirect
if (!$order) {
    header('Location: index.php');
    exit();
}

// Get order items
$stmt = $conn->prepare("
    SELECT * FROM order_items 
    WHERE order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Confirmation - TechHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
      .confirmation-container {
        max-width: 1000px;
        margin: 3rem auto;
        padding: 2.5rem;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      }

      .confirmation-header {
        text-align: center;
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #f0f3ff;
      }

      .confirmation-icon {
        text-align: center;
        margin-bottom: 1.5rem;
      }

      .confirmation-icon i {
        font-size: 5rem;
        color: #22c55e;
        animation: scaleIn 0.5s ease-out;
      }

      @keyframes scaleIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
      }

      .confirmation-title {
        color: #1e293b;
        font-size: 2.2rem;
        margin-bottom: 1rem;
        font-weight: 700;
      }

      .confirmation-message {
        color: #64748b;
        font-size: 1.1rem;
        line-height: 1.6;
      }

      .order-details {
        background-color: #f8fafc;
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 2.5rem;
      }

      .order-details h3 {
        color: #1e293b;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
      }

      .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
      }

      .detail-item {
        background-color: white;
        padding: 1.2rem;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
      }

      .detail-item strong {
        display: block;
        color: #64748b;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
      }

      .detail-item span {
        color: #1e293b;
        font-size: 1.1rem;
        line-height: 1.5;
      }

      .items-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 1.5rem;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
      }

      .items-table th,
      .items-table td {
        padding: 1.2rem;
        text-align: left;
      }

      .items-table th {
        background-color: #f1f5f9;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
      }

      .items-table td {
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b;
      }

      .items-table tbody tr:last-child td {
        border-bottom: none;
      }

      .items-table tbody tr:hover {
        background-color: #f8fafc;
      }

      .price-summary {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
      }

      .price-row {
        display: flex;
        justify-content: space-between;
        padding: 0.8rem 0;
        color: #64748b;
      }

      .price-row.total {
        border-top: 2px solid #e2e8f0;
        margin-top: 0.8rem;
        padding-top: 1.2rem;
        color: #1e293b;
        font-weight: 600;
        font-size: 1.2rem;
      }

      .action-buttons {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 3rem;
      }

      .btn {
        padding: 1rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
      }

      .btn i {
        font-size: 1.1rem;
      }

      .btn-primary {
        background-color: #4f46e5;
        color: white;
      }

      .btn-primary:hover {
        background-color: #4338ca;
        transform: translateY(-2px);
      }

      .btn-secondary {
        background-color: #f1f5f9;
        color: #475569;
      }

      .btn-secondary:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
      }

      .order-status {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: capitalize;
      }

      .status-pending {
        background-color: #fef3c7;
        color: #92400e;
      }

      .status-processing {
        background-color: #e0f2fe;
        color: #075985;
      }

      .status-completed {
        background-color: #dcfce7;
        color: #166534;
      }

      @media (max-width: 768px) {
        .confirmation-container {
          margin: 1.5rem;
          padding: 1.5rem;
        }

        .confirmation-title {
          font-size: 1.8rem;
        }

        .details-grid {
          grid-template-columns: 1fr;
          gap: 1rem;
        }

        .items-table {
          display: block;
          overflow-x: auto;
        }

        .action-buttons {
          flex-direction: column;
        }

        .btn {
          width: 100%;
          justify-content: center;
        }
      }
    </style>
  </head>
  <body>
    <?php include "header.html"; ?>

    <main class="main-content">
      <div class="confirmation-container">
        <div class="confirmation-header">
          <div class="confirmation-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <h1 class="confirmation-title">Thanks For Your Order!</h1>
          <p class="confirmation-message">
            Order <strong>#<?php echo htmlspecialchars($order['order_number']); ?></strong> has been successfully placed.<br>
            We've sent a confirmation email to <strong><?php echo htmlspecialchars($order['email']); ?></strong>.
          </p>
        </div>

        <div class="order-details">
          <h3>Order Information</h3>
          <div class="details-grid">
            <div class="detail-item">
              <strong>Order Date</strong>
              <span><?php echo $order['formatted_date']; ?></span>
            </div>
            <div class="detail-item">
              <strong>Order Status</strong>
              <span class="order-status status-<?php echo strtolower($order['status']); ?>">
                <?php echo htmlspecialchars($order['status']); ?>
              </span>
            </div>
            <div class="detail-item">
              <strong>Payment Method</strong>
              <span>
                <i class="<?php echo $order['payment_method'] === 'Credit Card' ? 'credit-card' : 'money-bill'; ?>"></i>
                <?php echo htmlspecialchars($order['payment_method']); ?>
              </span>
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

          <h3>Order Items</h3>
          <table class="items-table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($item = $items->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                <td>$<?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>

          <div class="price-summary">
            <div class="price-row">
              <span>Subtotal</span>
              <span>$<?php echo number_format($order['subtotal'], 2); ?></span>
            </div>
            <div class="price-row">
              <span>Shipping</span>
              <span>$<?php echo number_format($order['shipping'], 2); ?></span>
            </div>
            <div class="price-row">
              <span>Tax</span>
              <span>$<?php echo number_format($order['tax'], 2); ?></span>
            </div>
            <div class="price-row total">
              <span>Total</span>
              <span>$<?php echo number_format($order['total'], 2); ?></span>
            </div>
          </div>
        </div>

        <div class="action-buttons">
          <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Continue Shopping
          </a>
          <a href="account.php" class="btn btn-primary">
            <i class="fas fa-user"></i> View Order History
          </a>
        </div>
      </div>
    </main>

    <?php include "footer.html"; ?>
  </body>
</html>
