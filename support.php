<?php
// Initialize session at the very beginning before any output
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechHub - Support</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="index.php" />
    <style>
      /* Support Page Specific Styles */
      .support-hero {
        background: linear-gradient(135deg, #0c2340, #1e4976);
        color: white;
        padding: 60px 0;
        text-align: center;
      }

      .support-hero h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
      }

      .support-hero p {
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto 30px;
      }

      .search-support {
        max-width: 650px;
        margin: 0 auto;
        display: flex;
      }

      .search-support input {
        flex: 1;
        padding: 15px 20px;
        border: none;
        border-radius: 4px 0 0 4px;
        font-size: 1rem;
      }

      .search-support button {
        background-color: #ff6b00;
        color: white;
        border: none;
        padding: 0 25px;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
      }

      .support-options {
        padding: 60px 0;
      }

      .support-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
      }

      .support-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
      }

      .support-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      }

      .support-card i {
        font-size: 3rem;
        color: #0c2340;
        margin-bottom: 20px;
      }

      .support-card h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #0c2340;
      }

      .support-card p {
        margin-bottom: 20px;
        color: #555;
      }

      .support-btn {
        display: inline-block;
        background-color: #0c2340;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s;
      }

      .support-btn:hover {
        background-color: #1e4976;
      }

      .faq-section {
        background-color: #f8f9fa;
        padding: 60px 0;
      }

      .faq-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
      }

      .section-header {
        text-align: center;
        margin-bottom: 40px;
      }

      .section-title {
        font-size: 2rem;
        color: #0c2340;
        margin-bottom: 15px;
      }

      .faq-item {
        background-color: white;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
      }

      .faq-question {
        padding: 20px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #0c2340;
      }

      .faq-question i {
        transition: transform 0.3s;
      }

      .faq-answer {
        padding: 0 20px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out, padding 0.3s ease;
      }

      .faq-item.active .faq-question i {
        transform: rotate(180deg);
      }

      .faq-item.active .faq-answer {
        padding: 0 20px 20px;
        max-height: 1000px;
      }

      .ticket-section {
        padding: 60px 0;
      }

      .support-form {
        max-width: 800px;
        margin: 0 auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 40px;
      }

      .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
        gap: 20px;
      }

      .form-group {
        flex: 1 0 260px;
      }

      .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #0c2340;
      }

      .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
      }

      select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 12px;
      }

      textarea.form-control {
        min-height: 150px;
        resize: vertical;
      }

      .submit-btn {
        background-color: #ff6b00;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
      }

      .submit-btn:hover {
        background-color: #e05d00;
      }

      .form-note {
        font-size: 0.9rem;
        color: #666;
        margin-top: 20px;
      }

      .help-center-section {
        background-color: #f8f9fa;
        padding: 60px 0;
      }

      .resources-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
      }

      .resource-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s;
      }

      .resource-card:hover {
        transform: translateY(-5px);
      }

      .resource-img {
        height: 160px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
      }

      .resource-img img {
        max-width: 100%;
        height: auto;
      }

      .resource-content {
        padding: 20px;
      }

      .resource-content h3 {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #0c2340;
      }

      .resource-content p {
        color: #555;
        margin-bottom: 15px;
      }

      .resource-link {
        color: #ff6b00;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
      }

      .resource-link i {
        margin-left: 5px;
        transition: transform 0.2s;
      }

      .resource-link:hover i {
        transform: translateX(3px);
      }

      .contact-section {
        padding: 60px 0;
      }

      .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
      }

      .contact-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        text-align: center;
      }

      .contact-card i {
        font-size: 2.5rem;
        color: #0c2340;
        margin-bottom: 15px;
      }

      .contact-card h3 {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #0c2340;
      }

      .contact-card p {
        color: #555;
        margin-bottom: 15px;
      }

      .contact-card a {
        color: #ff6b00;
        text-decoration: none;
        font-weight: 600;
      }

      .status-section {
        background-color: #0c2340;
        color: white;
        padding: 30px 0;
        text-align: center;
      }

      .status-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
      }

      .status-text {
        flex: 1;
        min-width: 280px;
        margin-bottom: 20px;
      }

      .status-text h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
      }

      .status-indicators {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
      }

      .status-item {
        display: flex;
        align-items: center;
      }

      .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
      }

      .status-dot.green {
        background-color: #28a745;
      }

      .status-dot.orange {
        background-color: #fd7e14;
      }

      /* Responsive adjustments */
      @media (max-width: 768px) {
        .support-grid {
          grid-template-columns: repeat(1, 1fr);
        }

        .search-support {
          flex-direction: column;
        }

        .search-support input {
          border-radius: 4px 4px 0 0;
        }

        .search-support button {
          border-radius: 0 0 4px 4px;
          padding: 15px;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php include "header.html"; ?>

    <!-- Support Hero Section -->
    <section class="support-hero">
      <div class="section-container">
        <h1>How Can We Help You?</h1>
        <p>
          Find answers to your questions or contact our support team for
          personalized assistance.
        </p>
        <div class="search-support">
          <input
            type="text"
            placeholder="Search for help articles, FAQs, or troubleshooting guides..."
            aria-label="Search support"
          />
          <button type="submit">Search</button>
        </div>
      </div>
    </section>

    <!-- Support Options Section -->
    <section class="support-options">
      <div class="support-grid">
        <!-- Support Card 1 -->
        <div class="support-card">
          <i class="fas fa-life-ring"></i>
          <h3>Customer Support</h3>
          <p>
            Need help with an order or have a question about our products? Our
            support team is ready to assist you.
          </p>
          <a href="#ticket-section" class="support-btn">Contact Support</a>
        </div>

        <!-- Support Card 2 -->
        <div class="support-card">
          <i class="fas fa-question-circle"></i>
          <h3>FAQs</h3>
          <p>
            Find quick answers to common questions about orders, returns,
            products, and more.
          </p>
          <a href="#faq-section" class="support-btn">View FAQs</a>
        </div>

        <!-- Support Card 3 -->
        <div class="support-card">
          <i class="fas fa-book"></i>
          <h3>Knowledge Base</h3>
          <p>
            Explore our comprehensive guides, tutorials, and troubleshooting
            resources.
          </p>
          <a href="#help-center-section" class="support-btn"
            >Browse Resources</a
          >
        </div>
      </div>
    </section>

    <!-- System Status Section -->
    <section class="status-section">
      <div class="status-container">
        <div class="status-text">
          <h3>System Status</h3>
          <p>Check the current status of our services and systems</p>
        </div>
        <div class="status-indicators">
          <div class="status-item">
            <span class="status-dot green"></span>
            <span>Website & Store: Operational</span>
          </div>
          <div class="status-item">
            <span class="status-dot green"></span>
            <span>Customer Portal: Operational</span>
          </div>
          <div class="status-item">
            <span class="status-dot orange"></span>
            <span>Order Processing: Minor Delays</span>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section" id="faq-section">
      <div class="faq-container">
        <div class="section-header">
          <h2 class="section-title">Frequently Asked Questions</h2>
          <p>Find answers to our most commonly asked questions</p>
        </div>

        <div class="faq-list">
          <!-- FAQ Item 1 -->
          <div class="faq-item">
            <div class="faq-question">
              How do I track my order?
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                You can track your order by logging into your account and
                visiting the "Order History" section. Alternatively, use the
                "Track Order" link in the footer of our website. You'll need
                your order number and the email address used to place the order.
              </p>
            </div>
          </div>

          <!-- FAQ Item 2 -->
          <div class="faq-item">
            <div class="faq-question">
              What is your return policy?
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                We offer a 30-day return policy for most products. Items must be
                returned in their original packaging and in new condition. Some
                products like CPUs and opened software may have different return
                policies. Restocking fees may apply to certain returns. Please
                visit our Returns page for detailed information.
              </p>
            </div>
          </div>

          <!-- FAQ Item 3 -->
          <div class="faq-item">
            <div class="faq-question">
              Do you offer international shipping?
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                Yes, we offer international shipping to many countries. Shipping
                rates, delivery times, and available methods vary by
                destination. Import duties, taxes, and customs fees may apply
                depending on your country's regulations and are the
                responsibility of the recipient.
              </p>
            </div>
          </div>

          <!-- FAQ Item 4 -->
          <div class="faq-item">
            <div class="faq-question">
              How do I redeem a promotional code?
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                To redeem a promotional code, add items to your cart and proceed
                to checkout. On the order review page, you'll find a field
                labeled "Promotional Code" or "Coupon Code" where you can enter
                your code. Click "Apply" to update your order total with the
                discount.
              </p>
            </div>
          </div>

          <!-- FAQ Item 5 -->
          <div class="faq-item">
            <div class="faq-question">
              Can I modify or cancel my order after it's placed?
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                You can modify or cancel your order if it hasn't been processed
                for shipping yet. Please contact our customer support team as
                soon as possible with your order number. Once an order has been
                processed for shipping, it cannot be modified or canceled.
              </p>
            </div>
          </div>

          <!-- FAQ Item 6 -->
          <div class="faq-item">
            <div class="faq-question">
              What warranty coverage do your products have?
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                Most products come with the manufacturer's warranty, which
                varies by product and brand. Many items also include TechHub's
                extended warranty options that can be purchased at checkout.
                Details of warranty coverage can be found on individual product
                pages. For warranty claims, please contact our support team with
                your order details.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Submit Ticket Section -->
    <section class="ticket-section" id="ticket-section">
      <div class="section-container">
        <div class="section-header">
          <h2 class="section-title">Contact Support</h2>
          <p>
            Submit a support ticket and we'll get back to you as soon as
            possible
          </p>
        </div>

        <?php
        // Display success message
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo '<div class="alert alert-success" role="alert" style="max-width: 800px; margin: 0 auto 20px; padding: 15px; border-radius: 5px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                    <strong>Success!</strong> Your support ticket has been submitted. We\'ll contact you shortly.
                  </div>';
            // Clear session variables
            unset($_SESSION['support_success']);
        }
        
        // Display error messages
        if (isset($_GET['error']) && $_GET['error'] == 1 && isset($_SESSION['support_errors'])) {
            echo '<div class="alert alert-danger" role="alert" style="max-width: 800px; margin: 0 auto 20px; padding: 15px; border-radius: 5px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                    <strong>Error!</strong> Please correct the following issues:<br>';
            foreach ($_SESSION['support_errors'] as $error) {
                echo '- ' . htmlspecialchars($error) . '<br>';
            }
            echo '</div>';
        }
        
        // Get form data from session if available (for repopulating the form after errors)
        $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
        
        // Clear session variables
        unset($_SESSION['support_errors'], $_SESSION['form_data']);
        ?>

        <div class="support-form">
          <form id="support-ticket-form" method="POST" action="process_support.php">
            <div class="form-row">
              <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>" required />
              </div>
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="order-number">Order Number (if applicable)</label>
                <input type="text" id="order-number" name="order_number" class="form-control" value="<?php echo htmlspecialchars($form_data['order_number'] ?? ''); ?>" />
              </div>
              <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" class="form-control" value="<?php echo htmlspecialchars($form_data['subject'] ?? ''); ?>" required />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="category">Support Category</label>
                <select id="category" name="category" class="form-control" required>
                  <option value="">Select a category</option>
                  <option value="order" <?php echo isset($form_data['category']) && $form_data['category'] === 'order' ? 'selected' : ''; ?>>Order Status & Shipping</option>
                  <option value="returns" <?php echo isset($form_data['category']) && $form_data['category'] === 'returns' ? 'selected' : ''; ?>>Returns & Refunds</option>
                  <option value="product" <?php echo isset($form_data['category']) && $form_data['category'] === 'product' ? 'selected' : ''; ?>>Product Information</option>
                  <option value="technical" <?php echo isset($form_data['category']) && $form_data['category'] === 'technical' ? 'selected' : ''; ?>>Technical Support</option>
                  <option value="account" <?php echo isset($form_data['category']) && $form_data['category'] === 'account' ? 'selected' : ''; ?>>Account Issues</option>
                  <option value="other" <?php echo isset($form_data['category']) && $form_data['category'] === 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
              </div>
              <div class="form-group">
                <label for="priority">Priority</label>
                <select id="priority" name="priority" class="form-control" required>
                  <option value="normal" <?php echo isset($form_data['priority']) && $form_data['priority'] === 'normal' ? 'selected' : ''; ?>>Normal</option>
                  <option value="high" <?php echo isset($form_data['priority']) && $form_data['priority'] === 'high' ? 'selected' : ''; ?>>High</option>
                  <option value="urgent" <?php echo isset($form_data['priority']) && $form_data['priority'] === 'urgent' ? 'selected' : ''; ?>>Urgent</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="message">Message</label>
              <textarea
                id="message"
                name="message"
                class="form-control"
                rows="6"
                required
              ><?php echo htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
              <label for="file">Attach Files (optional)</label>
              <input type="file" id="file" class="form-control" multiple />
              <small class="text-muted">File attachments will be available in a future update</small>
            </div>

            <button type="submit" class="submit-btn">Submit Ticket</button>

            <p class="form-note">
              Our support team will respond to your inquiry within 24 hours
              during business days. For urgent matters, please call our support
              hotline at 1-800-TECH-HUB.
            </p>
          </form>
        </div>
      </div>
    </section>

    <!-- Help Center Section -->
    <section class="help-center-section" id="help-center-section">
      <div class="section-container">
        <div class="section-header">
          <h2 class="section-title">Knowledge Base Resources</h2>
          <p>
            Explore our collection of guides, tutorials, and troubleshooting
            resources
          </p>
        </div>

        <div class="resources-grid">
          <!-- Resource Card 1 -->
          <div class="resource-card">
            <div class="resource-img">
              <img src="/api/placeholder/280/160" alt="Getting Started Guide" />
            </div>
            <div class="resource-content">
              <h3>Getting Started Guides</h3>
              <p>
                New to TechHub? Learn how to create an account, place orders,
                and navigate our website.
              </p>
              <a href="#" class="resource-link"
                >Read Guides <i class="fas fa-arrow-right"></i
              ></a>
            </div>
          </div>

          <!-- Resource Card 2 -->
          <div class="resource-card">
            <div class="resource-img">
              <img src="/api/placeholder/280/160" alt="PC Building Guide" />
            </div>
            <div class="resource-content">
              <h3>PC Building Guides</h3>
              <p>
                Step-by-step instructions for building your own PC, with tips
                for beginners and advanced builders.
              </p>
              <a href="#" class="resource-link"
                >Explore Guides <i class="fas fa-arrow-right"></i
              ></a>
            </div>
          </div>

          <!-- Resource Card 3 -->
          <div class="resource-card">
            <div class="resource-img">
              <img src="/api/placeholder/280/160" alt="Troubleshooting" />
            </div>
            <div class="resource-content">
              <h3>Troubleshooting</h3>
              <p>
                Solutions for common issues with hardware, software, and
                peripherals.
              </p>
              <a href="#" class="resource-link"
                >View Solutions <i class="fas fa-arrow-right"></i
              ></a>
            </div>
          </div>

          <!-- Resource Card 4 -->
          <div class="resource-card">
            <div class="resource-img">
              <img
                src="/api/placeholder/280/160"
                alt="Component Compatibility"
              />
            </div>
            <div class="resource-content">
              <h3>Component Compatibility</h3>
              <p>
                Learn how to check compatibility between different PC components
                before making a purchase.
              </p>
              <a href="#" class="resource-link"
                >Check Compatibility <i class="fas fa-arrow-right"></i
              ></a>
            </div>
          </div>

          <!-- Resource Card 5 -->
          <div class="resource-card">
            <div class="resource-img">
              <img src="/api/placeholder/280/160" alt="Software Tutorials" />
            </div>
            <div class="resource-content">
              <h3>Software Tutorials</h3>
              <p>
                Guides and tutorials for popular software, operating systems,
                and drivers.
              </p>
              <a href="#" class="resource-link"
                >Browse Tutorials <i class="fas fa-arrow-right"></i
              ></a>
            </div>
          </div>

          <!-- Resource Card 6 -->
          <div class="resource-card">
            <div class="resource-img">
              <img src="/api/placeholder/280/160" alt="Return Process" />
            </div>
            <div class="resource-content">
              <h3>Understanding the Return Process</h3>
              <p>
                Step-by-step guide to initiating a return and understanding our
                policies.
              </p>
              <a href="#" class="resource-link"
                >Learn More <i class="fas fa-arrow-right"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Information Section -->
    <section class="contact-section">
      <div class="section-container">
        <div class="section-header">
          <h2 class="section-title">Contact Us</h2>
          <p>
            Reach out to us through multiple channels for any inquiries or
            support needs
          </p>
        </div>

        <div class="contact-grid">
          <!-- Contact Card 1: Email -->
          <div class="contact-card">
            <i class="fas fa-envelope"></i>
            <h3>Email Support</h3>
            <p>
              Send us an email and we'll get back to you within 24 business
              hours.
            </p>
            <a href="#">techhub@gmail.com</a>
          </div>

          <!-- Contact Card 2: Phone -->
          <div class="contact-card">
            <i class="fas fa-phone"></i>
            <h3>Phone Support</h3>
            <p>Call us during business hours for immediate assistance.</p>
            <a href="#">X-XXX-TECH-HUB</a>
            <p>(Mon-Fri, 9 AM - 6 PM EST)</p>
          </div>

          <!-- Contact Card 3: Live Chat -->
          <div class="contact-card">
            <i class="fas fa-comments"></i>
            <h3>Live Chat</h3>
            <p>
              Chat with a support representative in real-time during business
              hours.
            </p>
            <a href="#" id="live-chat-link">Start Live Chat</a>
          </div>

          <!-- Contact Card 4: Social Media -->
          <div class="contact-card">
            <i class="fas fa-share-alt"></i>
            <h3>Social Media</h3>
            <p>Connect with us on social media for updates and support</p>
            <p>
              <a
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                ><i
                  class="fab fa-facebook-square fa-2x"
                  style="color: #1877f2"
                ></i
              ></a>
              <a
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                ><i
                  class="fab fa-twitter-square fa-2x"
                  style="color: #1da1f2"
                ></i
              ></a>
              <a
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                ><i
                  class="fab fa-instagram-square fa-2x"
                  style="color: #c13584"
                ></i
              ></a>
              <a
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                ><i class="fab fa-linkedin fa-2x" style="color: #0a66c2"></i
              ></a>
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>

    <!-- Back to top button -->
    <button id="back-to-top" class="back-to-top"><i class="fas fa-arrow-up"></i></button>
    
    <script>
      // Mobile Navigation Toggle
      document.getElementById("mobile-toggle").addEventListener("click", () => {
        const navLinks = document.getElementById("nav-links");
        navLinks.classList.toggle("active");
      });

      // Search Functionality (Simplified)
      document.getElementById("search-btn").addEventListener("click", () => {
        const searchTerm = document.getElementById("search-input").value;
        alert(`Searching for: ${searchTerm}`); // Replace with actual search logic
      });

      // Delete Individual Notification
      document.querySelectorAll(".notification-delete").forEach((button) => {
        button.addEventListener("click", (event) => {
          // Prevent event from bubbling up to the notification item itself, which may have its own click event.
          event.stopPropagation();
          const notificationItem = button.closest(".notification-item");
          notificationItem.remove();
        });
      });
    </script>
  </body>
</html>
