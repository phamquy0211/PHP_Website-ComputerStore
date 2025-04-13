<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: loginRegister.php");
    exit();
}

// Get user information from session
$userFullname = isset($_SESSION['user_fullname']) ? $_SESSION['user_fullname'] : 'User';
$userEmail = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'user@example.com';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechHub - Your Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
      .cart-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }
      .cart-container h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
      }
      .cart-items {
        margin-bottom: 30px;
      }
      .cart-item {
        display: flex;
        gap: 20px;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
      }
      .cart-item:last-child {
        border-bottom: none;
      }
      .cart-item-image img {
        width: 100px;
        height: auto;
        border-radius: 4px;
        border: 1px solid #eee;
      }
      .cart-item-details {
        flex-grow: 1;
      }
      .cart-item-title {
        font-weight: 600;
        margin-bottom: 5px;
      }
      .cart-item-specs {
        font-size: 0.9em;
        color: #666;
        margin-bottom: 10px;
      }
      .cart-item-price {
        font-weight: bold;
        color: #e63946;
        margin-bottom: 10px;
        font-size: 1.1em;
      }
      .cart-item-quantity label {
        display: block;
        font-size: 0.9em;
        margin-bottom: 5px;
      }
      .quantity-controls {
        display: flex;
        align-items: center;
      }
      .quantity-btn {
        background-color: #eee;
        border: 1px solid #ccc;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 1em;
        line-height: 1;
      }
      .quantity-input {
        width: 50px;
        text-align: center;
        border: 1px solid #ccc;
        border-left: none;
        border-right: none;
        padding: 5px;
        font-size: 1em;
        /* Remove spinner arrows */
        -moz-appearance: textfield;
        appearance: textfield;
      }
      .quantity-input::-webkit-outer-spin-button,
      .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      .cart-item-remove {
        background: none;
        border: none;
        color: #e63946;
        cursor: pointer;
        font-size: 1.2em;
        align-self: center;
        padding: 10px;
      }
      .cart-item-remove:hover {
        color: #c0392b;
      }

      .empty-cart-message {
        text-align: center;
        padding: 50px 20px;
        border: 2px dashed #eee;
        border-radius: 8px;
        color: #666;
      }
      .empty-cart-icon {
        font-size: 3em;
        margin-bottom: 20px;
        color: #ccc;
      }
      .empty-cart-message p {
        font-size: 1.2em;
        margin-bottom: 25px;
      }
      .continue-shopping {
        display: inline-block;
        padding: 12px 25px;
        background-color: #1a237e;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
      }
      .continue-shopping:hover {
        background-color: #283593;
      }

      .cart-summary {
        border-top: 2px solid #eee;
        padding-top: 20px;
        max-width: 400px;
        margin-left: auto;
      }
      .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 1em;
        color: #555;
      }
      .cart-total {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        font-size: 1.3em;
        font-weight: bold;
        color: #333;
        border-top: 1px solid #ccc;
        padding-top: 15px;
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
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php include "header.html"; ?>

    <!-- Shopping Cart Content -->
    <div class="cart-container">
      <h2>Your Shopping Cart</h2>

      <div class="cart-items" id="cart-items">
        <!-- Cart items will be dynamically loaded by cart.js -->
      </div>

      <!-- Empty Cart Message (Initially visible) -->
      <div class="empty-cart-message">
        <div class="empty-cart-icon"><i class="fas fa-shopping-cart"></i></div>
        <p>Your cart is currently empty.</p>
        <a href="index.php" class="continue-shopping">Continue Shopping</a>
      </div>

      <!-- Cart Summary (Initially hidden) -->
      <div class="cart-summary" style="display: none">
        <div class="summary-row cart-subtotal">
          <span>Subtotal:</span>
          <span id="subtotal">$0.00</span>
        </div>
        <div class="summary-row cart-shipping">
          <span>Shipping:</span>
          <span id="shipping">$0.00</span>
        </div>
        <div class="summary-row cart-tax">
          <span>Estimated Tax:</span>
          <span id="tax">$0.00</span>
        </div>
        <div class="cart-total">
          <span>Total:</span>
          <span id="total">$0.00</span>
        </div>

        <button class="checkout-btn" id="checkout-btn">
          <a
            href="checkout.php"
            style="
              color: white;
              text-decoration: none;
              display: block;
              width: 100%;
              height: 100%;
            "
            >Proceed to Checkout</a
          >
        </button>
      </div>
    </div>
    <!-- Cart Functionality -->
    <script src="cart.js"></script>

    <!-- Force cart update on page load -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        console.log("Cart page loaded, initializing cart");
        // Load cart from localStorage
        if (typeof loadCart === "function") {
          loadCart();
        }
        // Update cart display
        if (typeof window.updateCartDisplay === "function") {
          window.updateCartDisplay();
        } else {
          console.error(
            "updateCartDisplay function not found. Make sure cart.js is loaded properly."
          );
        }
      });

      // Update cart display function
      window.updateCartDisplay = function () {
        const cartItemsContainer = document.getElementById("cart-items");
        const emptyCartMessage = document.querySelector(".empty-cart-message");
        const cartSummary = document.querySelector(".cart-summary");

        if (!cartItemsContainer) {
          console.log("Cart items container not found, not on cart page");
          return;
        }

        // Fetch cart items from server
        fetch("get_cart_items.php")
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              // Clear current items
              cartItemsContainer.innerHTML = "";

              // Check if cart is empty
              if (data.items.length === 0) {
                if (emptyCartMessage) emptyCartMessage.style.display = "block";
                if (cartSummary) cartSummary.style.display = "none";
                return;
              }

              // Show cart summary, hide empty message
              if (emptyCartMessage) emptyCartMessage.style.display = "none";
              if (cartSummary) cartSummary.style.display = "block";

              // Add each item to the cart display
              data.items.forEach((item, index) => {
                // Ensure price is a number
                const price = parseFloat(item.price);

                const cartItemElement = document.createElement("div");
                cartItemElement.className = "cart-item";
                cartItemElement.innerHTML = `
                  <div class="cart-item-image">
                    <img src="${item.image || "/api/placeholder/240/180"}" alt="${item.name}" />
                  </div>
                  <div class="cart-item-details">
                    <div class="cart-item-title">${item.name}</div>
                    <div class="cart-item-specs">${item.specs || ""}</div>
                    <div class="cart-item-price">$${price.toFixed(2)}</div>
                    <div class="cart-item-quantity">
                      <label for="quantity${index}">Quantity:</label>
                      <div class="quantity-controls">
                        <button class="quantity-btn decrease" data-item-id="${item.id}">-</button>
                        <input type="number" id="quantity${index}" class="quantity-input"
                          value="${item.quantity}" min="1" max="10" data-item-id="${item.id}" />
                        <button class="quantity-btn increase" data-item-id="${item.id}">+</button>
                      </div>
                    </div>
                  </div>
                  <button class="cart-item-remove" data-item-id="${item.id}">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                `;

                cartItemsContainer.appendChild(cartItemElement);
              });

              // Update summary values
              document.getElementById("subtotal").textContent = `$${data.summary.subtotal}`;
              document.getElementById("shipping").textContent = data.summary.shipping === 0 ? "Free" : `$${data.summary.shipping}`;
              document.getElementById("tax").textContent = `$${data.summary.tax}`;
              document.getElementById("total").textContent = `$${data.summary.total}`;

              // Add event listeners to new elements
              setupCartItemEventListeners();
            } else {
              console.error("Failed to fetch cart items:", data.message);
            }
          })
          .catch((error) => {
            console.error("Error fetching cart items:", error);
          });
      };

      // Set up event listeners for cart items
      function setupCartItemEventListeners() {
        // Quantity decrease buttons
        document.querySelectorAll(".quantity-btn.decrease").forEach((button) => {
          button.addEventListener("click", function () {
            const itemId = this.getAttribute("data-item-id");
            updateItemQuantity(itemId, -1);
          });
        });

        // Quantity increase buttons
        document.querySelectorAll(".quantity-btn.increase").forEach((button) => {
          button.addEventListener("click", function () {
            const itemId = this.getAttribute("data-item-id");
            updateItemQuantity(itemId, 1);
          });
        });

        // Quantity input fields
        document.querySelectorAll(".quantity-input").forEach((input) => {
          input.addEventListener("change", function () {
            const itemId = this.getAttribute("data-item-id");
            const newQuantity = parseInt(this.value);
            setItemQuantity(itemId, newQuantity);
          });
        });

        // Remove item buttons
        document.querySelectorAll(".cart-item-remove").forEach((button) => {
          button.addEventListener("click", function () {
            const itemId = this.getAttribute("data-item-id");
            removeItemFromCart(itemId);
          });
        });
      }

      // Update item quantity by a delta amount
      function updateItemQuantity(itemId, delta) {
        // Find the input field to get the current quantity
        const inputField = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
        if (!inputField) {
          console.error("Quantity input field not found for item", itemId);
          return;
        }
        const currentQuantity = parseInt(inputField.value);
        const newQuantity = currentQuantity + delta;

        // Call setItemQuantity to handle validation and API call
        setItemQuantity(itemId, newQuantity);
      }

      // Set item quantity to a specific value and update server
      function setItemQuantity(itemId, quantity) {
        // Validate quantity (client-side)
        quantity = Math.max(0, Math.min(99, quantity)); // Allow 0 for removal via quantity change

        console.log(`Setting quantity for item ${itemId} to ${quantity}`);

        // Prepare data for API call
        const formData = new FormData();
        formData.append("item_id", itemId);
        formData.append("quantity", quantity);

        // Send update request to server
        fetch("update_cart_quantity.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
          })
          .then((data) => {
            console.log("Update quantity response:", data);
            if (data.success) {
              // Reload the cart display to show changes and updated totals
              window.updateCartDisplay();
              // Update cart count in header
              if (typeof data.cart_count !== "undefined") {
                updateCartCountInHeader(data.cart_count);
              }
            } else {
              console.error("Failed to update quantity:", data.message);
              alert("Failed to update quantity: " + data.message);
            }
          })
          .catch((error) => {
            console.error("Error updating quantity:", error);
            alert("An error occurred while updating the quantity.");
          });
      }

      // Remove item from cart via API
      function removeItemFromCart(itemId) {
        console.log(`Removing item ${itemId} from cart`);

        // Confirm before removing (optional but good UX)
        if (!confirm("Are you sure you want to remove this item from your cart?")) {
          return;
        }

        // Prepare data for API call
        const formData = new FormData();
        formData.append("item_id", itemId);

        // Send remove request to server
        fetch("remove_from_cart.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
          })
          .then((data) => {
            console.log("Remove item response:", data);
            if (data.success) {
              // Reload the cart display
              window.updateCartDisplay();
              // Update cart count in header
              if (typeof data.cart_count !== "undefined") {
                updateCartCountInHeader(data.cart_count);
              }
            } else {
              console.error("Failed to remove item:", data.message);
              alert("Failed to remove item: " + data.message);
            }
          })
          .catch((error) => {
            console.error("Error removing item:", error);
            alert("An error occurred while removing the item.");
          });
      }

      // Helper function to update cart count in header specifically
      function updateCartCountInHeader(count) {
        const cartCountElements = document.querySelectorAll(".cart-count");
        cartCountElements.forEach((element) => {
          element.textContent = count;
          element.style.display = count > 0 ? "inline-block" : "none";
        });
      }
    </script>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>

    <!-- Back to top button -->
    <button id="back-to-top" class="back-to-top">
      <i class="fas fa-arrow-up"></i>
    </button>
  </body>
</html>
