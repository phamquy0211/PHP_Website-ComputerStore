<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechHub - Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
      .checkout-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
      }

      .checkout-form {
        flex: 1 1 650px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
      }

      .order-summary {
        flex: 1 1 350px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
        align-self: flex-start;
        position: sticky;
        top: 20px;
      }

      .checkout-section {
        margin-bottom: 30px;
      }

      .checkout-section h3 {
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
        color: #333;
      }

      .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
      }

      .form-group {
        flex: 1 1 200px;
      }

      .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
      }

      .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 15px;
      }

      .form-control:focus {
        border-color: #1a237e;
        outline: none;
        box-shadow: 0 0 0 2px rgba(26, 35, 126, 0.2);
      }

      .checkout-btn {
        width: 100%;
        padding: 15px;
        background-color: #27ae60;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 15px;
      }

      .checkout-btn:hover {
        background-color: #229954;
      }

      .express-checkout {
        text-align: center;
        margin-bottom: 25px;
      }

      .express-btn {
        width: 100%;
        padding: 12px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
      }

      .paypal-btn {
        background-color: #0070ba;
        color: white;
      }

      .apple-pay-btn {
        background-color: #000;
        color: white;
      }

      .order-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
      }

      .order-item-image {
        width: 70px;
        height: 70px;
        border: 1px solid #eee;
        border-radius: 4px;
        overflow: hidden;
      }

      .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .order-item-details {
        flex-grow: 1;
      }

      .order-item-title {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 0.9em;
      }

      .order-item-price {
        font-weight: bold;
        color: #e63946;
      }

      .order-item-quantity {
        color: #666;
        font-size: 0.9em;
      }

      .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 1em;
        color: #555;
      }

      .order-total {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        font-size: 1.3em;
        font-weight: bold;
        color: #333;
        border-top: 1px solid #ccc;
        padding-top: 15px;
      }

      .payment-methods {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
      }

      .payment-method {
        flex: 1 1 calc(33.333% - 10px);
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
      }

      .payment-method.selected {
        border-color: #1a237e;
        background-color: rgba(26, 35, 126, 0.05);
      }

      .payment-method i {
        font-size: 24px;
        margin-bottom: 5px;
        display: block;
      }

      .payment-details {
        margin-top: 20px;
      }

      .remove-checkout-item {
        background: none;
        border: none;
        color: #e63946;
        cursor: pointer;
        font-size: 1.1em;
        padding: 0 5px;
        margin-left: 10px;
        line-height: 1;
      }

      .remove-checkout-item:hover {
        color: #c0392b;
      }

      @media (max-width: 768px) {
        .checkout-container {
          flex-direction: column;
        }

        .order-summary {
          position: relative;
          top: 0;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php include "header.html"; ?>

    <!-- Checkout Container -->
    <div class="checkout-container">
      <!-- Checkout Form -->
      <div class="checkout-form">
        <h2>Checkout</h2>

        <!-- Shipping Address Section -->
        <div class="checkout-section">
          <h3>Shipping Address</h3>
          <div class="form-row">
            <div class="form-group">
              <label for="firstname">First Name*</label>
              <input type="text" id="firstname" class="form-control" required />
            </div>
            <div class="form-group">
              <label for="lastname">Last Name*</label>
              <input type="text" id="lastname" class="form-control" required />
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email Address*</label>
            <input type="email" id="email" class="form-control" required />
          </div>
          <div class="form-group">
            <label for="phone">Phone Number*</label>
            <input type="tel" id="phone" class="form-control" required />
          </div>
          <div class="form-group">
            <label for="address">Street Address*</label>
            <input type="text" id="address" class="form-control" required />
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="city">City*</label>
              <input type="text" id="city" class="form-control" required />
            </div>
            <div class="form-group">
              <label for="state">State/Province*</label>
              <input type="text" id="state" class="form-control" required />
            </div>
          </div>
          <div class="form-group">
            <label for="country">Country*</label>
            <select id="country" class="form-control" required>
              <option value="">Select a country</option>
              <option value="US">United States</option>
              <option value="CA">Canada</option>
              <option value="UK">United Kingdom</option>
              <option value="VN">Viet Nam</option>
              <!-- Add more countries as needed -->
            </select>
          </div>
        </div>
      </div>
      <!-- Order Summary -->
      <div class="order-summary">
        <h3>Order Summary</h3>
        <div class="order-items" id="order-items-container">
          <!-- Order items will be loaded here -->
        </div>
        <div class="summary-row cart-subtotal">
          <span>Subtotal:</span>
          <span id="checkout-subtotal">$0.00</span>
        </div>
        <div class="summary-row cart-shipping">
          <span>Shipping:</span>
          <span id="checkout-shipping">$0.00</span>
        </div>
        <div class="summary-row cart-tax">
          <span>Estimated Tax:</span>
          <span id="checkout-tax">$0.00</span>
        </div>
        <div class="order-total">
          <span>Total:</span>
          <span id="checkout-total">$0.00</span>
        </div>
        <button class="checkout-btn" id="place-order-btn">Place Order</button>
        <div class="terms-agreement" style=" margin-top: 15px; font-size: 0.85em; color: #666; text-align: center; ">
          By placing your order, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
        </div>
      </div>
    </div>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>

    <!-- Back to top button -->
    <button id="back-to-top" class="back-to-top">
      <i class="fas fa-arrow-up"></i>
    </button>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const orderItemsContainer = document.getElementById("order-items-container");

        // Load cart items from server
        function loadCartItems() {
          console.log("Loading cart items from server...");
          orderItemsContainer.innerHTML =
            '<div class="loading-message">Loading cart...</div>';

          fetch("get_cart_items.php")
            .then((response) => {
              if (!response.ok) {
                throw new Error("Network response was not ok");
              }
              return response.json();
            })
            .then((data) => {
              console.log("Server response:", data);

              if (!data.success) {
                orderItemsContainer.innerHTML = `<div class="error-message">Error: ${
                  data.message || "Failed to load cart"
                }</div>`;
                updateSummaryTotals(0, 0, 0, 0);
                return;
              }

              renderCartItems(data.items);
              updateSummaryTotals(
                data.summary.subtotal,
                data.summary.shipping,
                data.summary.tax,
                data.summary.total
              );
            })
            .catch((error) => {
              console.error("Error loading cart items:", error);
              orderItemsContainer.innerHTML = `<div class="error-message">Error loading cart. ${error.message}</div>`;
              updateSummaryTotals(0, 0, 0, 0);
            });
        }

        // Function to render cart items in the DOM
        function renderCartItems(items) {
          if (!items || items.length === 0) {
            orderItemsContainer.innerHTML =
              '<div class="empty-cart-message">Your cart is empty</div>';
            return;
          }

          let html = "";
          items.forEach((item) => {
            console.log("Processing item:", item);
            html += `
              <div class="order-item" data-item-id="${item.id}">
                <div class="order-item-image">
                  <img src="${item.image || "/api/placeholder/80/80"}" alt="${
              item.name
            }" />
                </div>
                <div class="order-item-details">
                  <div class="order-item-title">${item.name}</div>
                  <div class="order-item-price">$${parseFloat(
                    item.price
                  ).toFixed(2)}</div>
                  <div class="order-item-quantity">Qty: ${item.quantity}</div>
                </div>
                <button class="remove-checkout-item" data-item-id="${
                  item.id
                }" title="Remove item">&times;</button>
              </div>
            `;
          });
          orderItemsContainer.innerHTML = html;
        }

        // Function to update summary totals
        function updateSummaryTotals(subtotal, shipping, tax, total) {
          document.getElementById(
            "checkout-subtotal"
          ).textContent = `$${parseFloat(subtotal).toFixed(2)}`;
          document.getElementById("checkout-shipping").textContent =
            shipping === 0 ? "Free" : `$${parseFloat(shipping).toFixed(2)}`;
          document.getElementById("checkout-tax").textContent = `$${parseFloat(
            tax
          ).toFixed(2)}`;
          document.getElementById(
            "checkout-total"
          ).textContent = `$${parseFloat(total).toFixed(2)}`;
        }

        // --- Event Listener for Removing Items ---
        orderItemsContainer.addEventListener("click", function (event) {
          if (event.target.classList.contains("remove-checkout-item")) {
            const button = event.target;
            const itemId = button.dataset.itemId;
            const orderItemElement = button.closest(".order-item");

            if (!itemId || !orderItemElement) return;

            console.log(`Attempting to remove item with ID: ${itemId}`);
            button.disabled = true;
            orderItemElement.style.opacity = "0.5";

            fetch("remove_checkout_item.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded",
              },
              body: new URLSearchParams({ cart_item_id: itemId }),
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  console.log(`Item ${itemId} removed successfully.`);
                  orderItemElement.remove();
                  loadCartItems();
                } else {
                  console.error("Error removing item:", data.message);
                  alert(`Error removing item: ${data.message}`);
                  button.disabled = false;
                  orderItemElement.style.opacity = "1";
                }
              })
              .catch((error) => {
                console.error("Fetch error removing item:", error);
                alert(
                  "An error occurred while removing the item. Please try again."
                );
                button.disabled = false;
                orderItemElement.style.opacity = "1";
              });
          }
        });

        // Initial load
        loadCartItems();

        // Payment method selection
        const paymentMethods = document.querySelectorAll(".payment-method");
        const creditCardDetails = document.getElementById("credit-card-details");

        paymentMethods.forEach((method) => {
          method.addEventListener("click", function () {
            // Remove selected class from all methods
            paymentMethods.forEach((m) => m.classList.remove("selected"));
            // Add selected class to clicked method
            this.classList.add("selected");

            // Show/hide payment details based on selection
            const selectedMethod = this.getAttribute("data-method");
            if (selectedMethod === "credit-card") {
              creditCardDetails.style.display = "block";
            } else {
              creditCardDetails.style.display = "none";
            }
          });
        });

        // Place order button event
        const placeOrderBtn = document.getElementById("place-order-btn");
        placeOrderBtn.addEventListener("click", function () {
          // Basic form validation
          const requiredFields = document.querySelectorAll("[required]");
          let isValid = true;

          requiredFields.forEach((field) => {
            if (!field.value.trim()) {
              field.style.borderColor = "#e63946";
              isValid = false;
            } else {
              field.style.borderColor = "#ddd";
            }
          });

          if (isValid) {
            // Disable the button to prevent double submission
            placeOrderBtn.disabled = true;
            placeOrderBtn.textContent = "Processing...";

            // Collect form data
            const formData = new FormData();
            formData.append("firstname", document.getElementById("firstname").value);
            formData.append("lastname", document.getElementById("lastname").value);
            formData.append("email", document.getElementById("email").value);
            formData.append("phone", document.getElementById("phone").value);
            formData.append("address", document.getElementById("address").value);
            formData.append("city", document.getElementById("city").value);
            formData.append("state", document.getElementById("state").value);
            formData.append("country", document.getElementById("country").value);
            formData.append("zip_code", document.getElementById("zip_code")?.value || '');
            formData.append("payment_method", "Credit card");

            // Send data to server
            fetch("process_checkout.php", {
              method: "POST",
              body: formData
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              if (data.success) {
                // Clear cart
                localStorage.removeItem("techHubCart");
                
                // Show success message
                alert("Order placed successfully! Redirecting to confirmation page...");
                
                // Redirect to order confirmation
                window.location.href = "orderConfirm.php?order_id=" + data.order_id;
              } else {
                // Re-enable the button
                placeOrderBtn.disabled = false;
                placeOrderBtn.textContent = "Place Order";
                
                // Show error message
                alert(data.message || "Error processing order. Please try again.");
              }
            })
            .catch(error => {
              console.error("Error:", error);
              
              // Re-enable the button
              placeOrderBtn.disabled = false;
              placeOrderBtn.textContent = "Place Order";
              
              // Show error message
              alert("An error occurred while processing your order. Please try again.");
            });
          } else {
            alert("Please fill in all required fields before placing your order.");
          }
        });

        // Toggle mobile menu and notification panel
        const mobileToggle = document.getElementById("mobile-toggle");
        const navLinks = document.getElementById("nav-links");
        const overlay = document.getElementById("overlay");

        mobileToggle?.addEventListener("click", function () {
          navLinks.classList.toggle("active");
          overlay.classList.toggle("active");
        });

        // Back to top button
        const backToTopBtn = document.getElementById("back-to-top");
        window.addEventListener("scroll", function () {
          if (window.pageYOffset > 300) {
            backToTopBtn.style.display = "block";
          } else {
            backToTopBtn.style.display = "none";
          }
        });

        backToTopBtn.addEventListener("click", function () {
          window.scrollTo({ top: 0, behavior: "smooth" });
        });
      });
    </script>
    <script src="cart.js"></script>
  </body>
</html>
