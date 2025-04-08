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
        max-width: 800px;
        margin: 50px auto;
        padding: 30px 40px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
      }

      .confirmation-icon {
        font-size: 5em;
        color: #27ae60;
        margin-bottom: 20px;
      }

      .confirmation-title {
        font-size: 2em;
        color: #333;
        margin-bottom: 15px;
        font-weight: 600;
      }

      .confirmation-message {
        font-size: 1.1em;
        color: #555;
        margin-bottom: 30px;
        line-height: 1.6;
      }
      .confirmation-message strong {
        color: #333;
      }

      .order-details-box {
        text-align: left;
        margin: 30px 0;
        padding: 25px;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
      }

      .order-details-box h3 {
        font-size: 1.4em;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
        color: #1a237e;
      }

      .order-info p,
      .order-summary p {
        margin: 12px 0;
        color: #4b5563;
        font-size: 1em;
      }
      .order-info strong,
      .order-summary strong {
        color: #1f2937;
        min-width: 120px;
        display: inline-block;
      }

      .order-items-list {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
      }
      .order-items-list h4 {
        font-size: 1.2em;
        margin-bottom: 15px;
        color: #333;
      }
      .order-item {
        display: flex;
        gap: 15px;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
        align-items: center;
      }
      .order-item:last-child {
        border-bottom: none;
      }
      .order-item-name {
        flex-grow: 1;
        font-size: 0.95em;
        color: #374151;
      }
      .order-item-qty {
        color: #6b7280;
        font-size: 0.9em;
        margin-left: auto;
        padding-left: 15px;
      }
      .order-item-price {
        font-weight: 600;
        color: #1f2937;
        min-width: 80px;
        text-align: right;
      }

      .order-summary {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
      }
      .order-summary p {
        display: flex;
        justify-content: space-between;
      }
      .order-summary p.total {
        font-size: 1.2em;
        font-weight: bold;
        color: #1a237e;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #d1d5db;
      }

      .action-buttons {
        margin-top: 40px;
        display: flex;
        justify-content: center;
        gap: 15px;
      }

      .btn {
        display: inline-block;
        padding: 12px 25px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 1em;
        border: 1px solid transparent;
      }

      .btn-primary {
        background-color: #1a237e;
        color: white;
        border-color: #1a237e;
      }
      .btn-primary:hover {
        background-color: #283593;
        border-color: #283593;
      }

      .btn-secondary {
        background-color: transparent;
        color: #1a237e;
        border-color: #1a237e;
      }
      .btn-secondary:hover {
        background-color: #e8eaf6;
        color: #1a237e;
      }

      .loading-message,
      .error-message {
        font-size: 1.1em;
        color: #6b7280;
        padding: 20px;
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php include "header.html"; ?>

    <!-- Main Content -->
    <main class="main-content">
      <div class="confirmation-container">
        <div class="confirmation-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="confirmation-title">Order Confirmed!</h1>
        <p class="confirmation-message">
          Thank you for your purchase. Your order
          <strong id="order-id-display"></strong> has been successfully placed.
          A confirmation email has been sent to
          <strong id="customer-email-display"></strong>.
        </p>

        <div class="order-details-box" id="order-details-content">
          <!-- Order details will be loaded here by JavaScript -->
          <div class="loading-message">Loading order details...</div>
        </div>

        <div class="action-buttons">
          <a href="index.php" class="btn btn-primary">Continue Shopping</a>
          <a href="account.php#orders" class="btn btn-secondary"
            >View Order History</a
          >
          <!-- Link to orders section in account page -->
        </div>
      </div>
    </main>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const orderDetailsContainer = document.getElementById(
          "order-details-content"
        );
        const orderIdDisplay = document.getElementById("order-id-display");
        const customerEmailDisplay = document.getElementById(
          "customer-email-display"
        );

        // Get order ID from URL query parameter
        const urlParams = new URLSearchParams(window.location.search);
        const orderId = urlParams.get("order_id");

        if (!orderId) {
          orderDetailsContainer.innerHTML =
            '<div class="error-message">Error: Order ID not found in URL.</div>';
          orderIdDisplay.textContent = "[Not Found]";
          customerEmailDisplay.textContent = "[Unknown]";
          return;
        }

        orderIdDisplay.textContent = `#${orderId}`;

        // Fetch order details from the server
        fetch(`get_order_details.php?order_id=${orderId}`)
          .then((response) => {
            if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
          })
          .then((data) => {
            if (data.success) {
              displayOrderDetails(data.order, data.items);
              customerEmailDisplay.textContent = data.order.email; // Display customer email
            } else {
              throw new Error(data.message || "Failed to load order details.");
            }
          })
          .catch((error) => {
            console.error("Error fetching order details:", error);
            orderDetailsContainer.innerHTML = `<div class="error-message">Error loading order details: ${error.message}</div>`;
            customerEmailDisplay.textContent = "[Error Loading]";
          });

        function displayOrderDetails(order, items) {
          // Format date (optional)
          const orderDate = new Date(order.created_at).toLocaleDateString(
            "en-US",
            {
              year: "numeric",
              month: "long",
              day: "numeric",
            }
          );

          let itemsHtml = "";
          items.forEach((item) => {
            itemsHtml += `
                        <div class="order-item">
                            <span class="order-item-name">${
                              item.product_name
                            }</span>
                            <span class="order-item-qty">Qty: ${
                              item.quantity
                            }</span>
                            <span class="order-item-price">$${parseFloat(
                              item.price
                            ).toFixed(2)}</span>
                </div>
          `;
          });

          orderDetailsContainer.innerHTML = `
                    <h3>Order Summary (#${order.id})</h3>
                    <div class="order-info">
                        <p><strong>Order Date:</strong> ${orderDate}</p>
                        <p><strong>Customer:</strong> ${order.first_name} ${
            order.last_name
          }</p>
                        <p><strong>Email:</strong> ${order.email}</p>
                        <p><strong>Shipping To:</strong> ${order.address}, ${
            order.city
          }, ${order.state}, ${order.country} ${order.zip_code || ""}</p>
                    </div>
                    <div class="order-items-list">
                        <h4>Items Purchased</h4>
                        ${itemsHtml}
            </div>
            <div class="order-summary">
                        <p><strong>Subtotal:</strong> <span>$${parseFloat(
                          order.subtotal
                        ).toFixed(2)}</span></p>
                        <p><strong>Shipping:</strong> <span>$${parseFloat(
                          order.shipping
                        ).toFixed(2)}</span></p>
                        <p><strong>Tax:</strong> <span>$${parseFloat(
                          order.tax
                        ).toFixed(2)}</span></p>
                        <p class="total"><strong>Total:</strong> <span>$${parseFloat(
                          order.total
                        ).toFixed(2)}</span></p>
          </div>
        `;
        }

        // Basic mobile menu toggle (copy from other pages if needed)
        const mobileToggle = document.getElementById("mobile-toggle");
        const navLinks = document.getElementById("nav-links");
        mobileToggle?.addEventListener("click", () => {
          navLinks?.classList.toggle("active");
        });
      });
    </script>
  </body>
</html>
