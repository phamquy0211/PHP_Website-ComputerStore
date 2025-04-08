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
        console.log("Cart page loaded, forcing cart update");
        // Make sure cart is loaded from localStorage
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
    </script>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>

    <!-- Back to top button -->
    <button id="back-to-top" class="back-to-top">
      <i class="fas fa-arrow-up"></i>
    </button>
  </body>
</html>
