<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechHub - Special Deals & Discounts</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="style.css" />
    <style>
      :root {
        --primary-color: #2563eb;
        --secondary-color: #8b5cf6;
        --accent-color: #f97316;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --text-dark: #1e293b;
        --text-light: #94a3b8;
        --bg-light: #f8fafc;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
          0 2px 4px -1px rgba(0, 0, 0, 0.06);
      }

      body {
        font-family: "Inter", "Segoe UI", system-ui, sans-serif;
        color: var(--text-dark);
        background-color: var(--bg-light);
        line-height: 1.5;
      }

      .deal-banner {
        background: linear-gradient(
          135deg,
          var(--primary-color),
          var(--secondary-color)
        );
        color: white;
        text-align: center;
        padding: 50px 20px;
        margin-bottom: 40px;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
      }

      .deal-banner h1 {
        font-size: 2.75rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -0.025em;
      }

      .deal-banner p {
        font-size: 1.25rem;
        max-width: 700px;
        margin: 0 auto 30px;
        opacity: 0.9;
      }

      .countdown-timer {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 30px 0;
      }

      .countdown-box {
        background-color: rgba(255, 255, 255, 0.15);
        padding: 15px;
        border-radius: 10px;
        min-width: 90px;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.2);
      }

      .countdown-box .number {
        font-size: 2.5rem;
        font-weight: bold;
        display: block;
        line-height: 1;
      }

      .countdown-box .label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.8;
      }

      .deal-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        margin-bottom: 40px;
      }

      .deal-category {
        background-color: white;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        font-size: 0.95rem;
      }

      .deal-category:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
      }

      .deal-category.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
      }

      .deal-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
      }

      .deal-card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: white;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0, 0, 0, 0.05);
      }

      .deal-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
      }

      .deal-image {
        height: 220px;
        overflow: hidden;
        position: relative;
      }

      .deal-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
      }

      .deal-card:hover .deal-image img {
        transform: scale(1.05);
      }

      .deal-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--danger-color);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 0.9rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .deal-content {
        padding: 25px;
      }

      .deal-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.3;
        color: var(--text-dark);
      }

      .deal-price {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
      }

      .deal-current-price {
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--danger-color);
      }

      .deal-old-price {
        font-size: 1.1rem;
        text-decoration: line-through;
        color: var(--text-light);
      }

      .deal-savings {
        background-color: #fef3c7;
        color: #92400e;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
      }

      .deal-description {
        color: var(--text-light);
        margin-bottom: 20px;
        line-height: 1.6;
        font-size: 0.95rem;
      }

      .deal-cta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f1f5f9;
        padding-top: 20px;
      }

      .view-deal-btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
      }

      .view-deal-btn:hover {
        background-color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
      }

      .deal-expiry {
        color: var(--text-light);
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
      }

      .deal-expiry i {
        color: var(--danger-color);
      }

      .newsletter-box {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: white;
        padding: 50px 30px;
        border-radius: 16px;
        text-align: center;
        margin-bottom: 60px;
        box-shadow: var(--card-shadow);
      }

      .newsletter-box h3 {
        font-size: 1.8rem;
        margin-bottom: 15px;
        font-weight: 700;
      }

      .newsletter-box p {
        opacity: 0.8;
        max-width: 700px;
        margin: 0 auto 25px;
        font-size: 1.1rem;
      }

      .newsletter-form {
        display: flex;
        max-width: 550px;
        margin: 25px auto 0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        overflow: hidden;
      }

      .newsletter-input {
        flex: 1;
        padding: 16px 20px;
        border: none;
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.9);
      }

      .newsletter-input:focus {
        outline: none;
        background: white;
      }

      .newsletter-btn {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 0 28px;
        cursor: pointer;
        font-weight: bold;
        font-size: 1rem;
        transition: background-color 0.3s ease;
        white-space: nowrap;
      }

      .newsletter-btn:hover {
        background-color: #ea580c;
      }

      .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e2e8f0;
      }

      .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
      }

      .view-all {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s ease;
      }

      .view-all:hover {
        color: #1d4ed8;
      }

      .view-all i {
        font-size: 0.85rem;
      }

      @media (max-width: 768px) {
        .deal-banner h1 {
          font-size: 2rem;
        }

        .countdown-timer {
          flex-wrap: wrap;
        }

        .countdown-box {
          min-width: 70px;
        }

        .deal-grid {
          grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
          gap: 20px;
        }

        .newsletter-form {
          flex-direction: column;
          gap: 0;
        }

        .newsletter-input,
        .newsletter-btn {
          width: 100%;
          padding: 15px;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php include "header.html"; ?>

    <!-- Deals Banner -->
    <div class="section-container">
      <div class="deal-banner" style="margin-top: 40px">
        <h1>Tech Deals Extravaganza</h1>
        <p>
          Unlock incredible savings on premium tech products with limited-time
          offers. Don't miss your chance!
        </p>

        <div class="countdown-timer">
          <div class="countdown-box">
            <span class="number" id="days">02</span>
            <span class="label">Days</span>
          </div>
          <div class="countdown-box">
            <span class="number" id="hours">18</span>
            <span class="label">Hours</span>
          </div>
          <div class="countdown-box">
            <span class="number" id="minutes">45</span>
            <span class="label">Minutes</span>
          </div>
          <div class="countdown-box">
            <span class="number" id="seconds">33</span>
            <span class="label">Seconds</span>
          </div>
        </div>
      </div>

      <!-- Deal Categories -->
      <div class="deal-categories">
        <div class="deal-category active">All Deals</div>
        <div class="deal-category">Components</div>
        <div class="deal-category">Laptops</div>
        <div class="deal-category">Monitors</div>
        <div class="deal-category">Peripherals</div>
        <div class="deal-category">Accessories</div>
      </div>

      <!-- Deal Products -->
      <div class="deal-grid">
        <!-- Deal 1 -->
        <div class="deal-card">
          <div class="deal-image">
            <i
              src="/img/4070.jp
              alt="RTX 4070 Ti Super"
            />
            <div class="deal-badge">-20%</div>
          </div>
          <div class="deal-content">
            <h3 class="deal-title">NVIDIA RTX 4070 Ti Super 16GB</h3>
            <div class="deal-price">
              <span class="deal-current-price">$799.99</span>
              <span class="deal-old-price">$999.99</span>
              <span class="deal-savings">Save $200</span>
            </div>
            <p class="deal-description">
              Experience next-gen gaming with the latest RTX 4070 Ti Super. Ray
              tracing, DLSS 3, and unparalleled performance.
            </p>
            <div class="deal-cta">
              <button class="view-deal-btn">View Deal</button>
              <span class="deal-expiry"
                ><i class="fas fa-clock"></i> Ends in 2 days</span
              >
            </div>
          </div>
        </div>

        <!-- Deal 2 -->
        <div class="deal-card">
          <div class="deal-image">
            <img
              src="/img/G15.png"
              alt="ASUS ROG Strix G15"
            />
            <div class="deal-badge">-15%</div>
          </div>
          <div class="deal-content">
            <h3 class="deal-title">ASUS ROG Strix G15 Gaming Laptop</h3>
            <div class="deal-price">
              <span class="deal-current-price">$1,399.99</span>
              <span class="deal-old-price">$1,649.99</span>
              <span class="deal-savings">Save $250</span>
            </div>
            <p class="deal-description">
              15.6" 165Hz display, AMD Ryzen 9, RTX 4060, 16GB RAM, 1TB SSD.
              Perfect for gaming and creative work.
            </p>
            <div class="deal-cta">
              <button class="view-deal-btn">View Deal</button>
              <span class="deal-expiry"
                ><i class="fas fa-clock"></i> Ends in 3 days</span
              >
            </div>
          </div>
        </div>

        <!-- Deal 3 -->
        <div class="deal-card">
          <div class="deal-image">
            <img
              src="/img/G7.jpg"
              alt="Samsung Odyssey G7"
            />
            <div class="deal-badge">-25%</div>
          </div>
          <div class="deal-content">
            <h3 class="deal-title">
              Samsung Odyssey G7 32" Curved Gaming Monitor
            </h3>
            <div class="deal-price">
              <span class="deal-current-price">$549.99</span>
              <span class="deal-old-price">$729.99</span>
              <span class="deal-savings">Save $180</span>
            </div>
            <p class="deal-description">
              32" QHD curved display with 240Hz refresh rate and 1ms response
              time. G-Sync and FreeSync Premium Pro.
            </p>
            <div class="deal-cta">
              <button class="view-deal-btn">View Deal</button>
              <span class="deal-expiry"
                ><i class="fas fa-clock"></i> Ends in 24 hours</span
              >
            </div>
          </div>
        </div>

        <!-- Deal 4 -->
        <div class="deal-card">
          <div class="deal-image">
            <img src="/img/K100.png" alt="Corsair K100 RGB" />
            <div class="deal-badge">-30%</div>
          </div>
          <div class="deal-content">
            <h3 class="deal-title">
              Corsair K100 RGB Optical-Mechanical Keyboard
            </h3>
            <div class="deal-price">
              <span class="deal-current-price">$159.99</span>
              <span class="deal-old-price">$229.99</span>
              <span class="deal-savings">Save $70</span>
            </div>
            <p class="deal-description">
              Premium gaming keyboard with OPX switches, RGB lighting, aluminum
              frame, and programmable keys.
            </p>
            <div class="deal-cta">
              <button class="view-deal-btn">View Deal</button>
              <span class="deal-expiry"
                ><i class="fas fa-clock"></i> Ends in 2 days</span
              >
            </div>
          </div>
        </div>

        <!-- Deal 5 -->
        <div class="deal-card">
          <div class="deal-image">
            <img src="/img/WB.jpg" alt="WD Black SN850X 2TB" />
            <div class="deal-badge">-35%</div>
          </div>
          <div class="deal-content">
            <h3 class="deal-title">WD Black SN850X 2TB NVMe SSD</h3>
            <div class="deal-price">
              <span class="deal-current-price">$149.99</span>
              <span class="deal-old-price">$229.99</span>
              <span class="deal-savings">Save $80</span>
            </div>
            <p class="deal-description">
              Ultra-fast PCIe Gen4 SSD with up to 7,300 MB/s read speeds.
              Perfect for gaming and content creation.
            </p>
            <div class="deal-cta">
              <button class="view-deal-btn">View Deal</button>
              <span class="deal-expiry"
                ><i class="fas fa-clock"></i> Ends in 3 days</span
              >
            </div>
          </div>
        </div>

        <!-- Deal 6 -->
        <div class="deal-card">
          <div class="deal-image">
            <img src="/img/ProX.jpg" alt="Logitech G Pro X" />
            <div class="deal-badge">-40%</div>
          </div>
          <div class="deal-content">
            <h3 class="deal-title">Logitech G Pro X Wireless Headset</h3>
            <div class="deal-price">
              <span class="deal-current-price">$119.99</span>
              <span class="deal-old-price">$199.99</span>
              <span class="deal-savings">Save $80</span>
            </div>
            <p class="deal-description">
              Professional-grade gaming headset with Blue VO!CE mic technology,
              DTS Headphone:X 2.0, and 20+ hour battery.
            </p>
            <div class="deal-cta">
              <button class="view-deal-btn">View Deal</button>
              <span class="deal-expiry"
                ><i class="fas fa-clock"></i> Ends in 24 hours</span
              >
            </div>
          </div>
        </div>
      </div>

      <!-- Newsletter Box -->
      <div class="newsletter-box">
        <h3>Never Miss a Deal Again</h3>
        <p>
          Join our community of tech enthusiasts and get exclusive access to
          flash sales, limited-time offers, and early product announcements.
        </p>
        <form class="newsletter-form">
          <input
            type="email"
            class="newsletter-input"
            placeholder="Enter your email address"
            required
          />
          <button type="submit" class="newsletter-btn">Subscribe Now</button>
        </form>
      </div>

      <!-- More Deals Section -->
      <div class="section-header">
        <h2 class="section-title">Clearance Sale</h2>
        <a href="#" class="view-all">
          Browse All Clearance <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <div class="deal-grid">
        <!-- Clearance Deal 1 -->
        <div class="deal-card">
          <div class="deal-image">
            <img src="/api/placeholder/350/200" alt="AMD Ryzen 5 5600X" />
            <div class="deal-badge">-45%</div>
          </div>
          <div class="deal-content">
            <h3 class="deal-title">AMD Ryzen 5 5600X 6-Core Processor</h3>
            <div class="deal-price">
              <span class="deal-current-price">$139.99</span>
              <span class="deal-old-price">$259.99</span>
              <span class="deal-savings">Save $120</span>
            </div>
            <p class="deal-description">
              6 cores, 12 threads, boost up to 4.6GHz. Great for gaming and
              productivity. Limited stock available.
            </p>
            <div class="deal-cta">
              <button class="view-deal-btn">View Deal</button>
              <span class="deal-expiry"
                ><i class="fas fa-exclamation-circle"></i> While supplies
                last</span
              >
            </div>
          </div>
        </div>

        <!-- Clearance Deal 2 -->
        <div class="deal-card">
          <div class="deal-image">
            <img src="/api/placeholder/350/200" alt="MSI MAG B550" />
            <div class="deal-badge">-50%</div>
          </div>
          <div class="deal-content">
            <h3 class="deal-title">MSI MAG B550 TOMAHAWK Motherboard</h3>
            <div class="deal-price">
              <span class="deal-current-price">$89.99</span>
              <span class="deal-old-price">$179.99</span>
              <span class="deal-savings">Save $90</span>
            </div>
            <p class="deal-description">
              AM4 socket, PCIe 4.0, Dual M.2 slots, USB 3.2 Gen 2, and excellent
              VRM thermals. Last units in stock.
            </p>
            <div class="deal-cta">
              <button class="view-deal-btn">View Deal</button>
              <span class="deal-expiry"
                ><i class="fas fa-exclamation-circle"></i> While supplies
                last</span
              >
            </div>
          </div>
        </div>

        <!-- Clearance Deal 3 -->
        <div class="deal-card">
          <div class="deal-image">
            <img src="/api/placeholder/350/200" alt="NZXT H510" />
            <div class="deal-badge">-60%</div>
          </div>
          <div class="deal-content">
            <h3 class="deal-title">NZXT H510 Compact ATX Mid-Tower Case</h3>
            <div class="deal-price">
              <span class="deal-current-price">$39.99</span>
              <span class="deal-old-price">$99.99</span>
              <span class="deal-savings">Save $60</span>
            </div>
            <p class="deal-description">
              Sleek design, cable management system, tempered glass side panel.
              Previous generation model.
            </p>
            <div class="deal-cta">
              <button class="view-deal-btn">View Deal</button>
              <span class="deal-expiry"
                ><i class="fas fa-exclamation-circle"></i> While supplies
                last</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>

    <!-- Back to top button -->
    <button id="back-to-top" class="back-to-top"><i class="fas fa-arrow-up"></i></button>

    <script src="script.js"></script>
    <script>
      // Load header and footer
      document.addEventListener("DOMContentLoaded", function () {
        // Improved countdown timer
        let deadline = new Date();
        deadline.setDate(deadline.getDate() + 2);
        deadline.setHours(deadline.getHours() + 18);
        deadline.setMinutes(deadline.getMinutes() + 45);
        deadline.setSeconds(deadline.getSeconds() + 33);

        function updateCountdown() {
          const now = new Date().getTime();
          const timeLeft = deadline.getTime() - now;

          if (timeLeft <= 0) {
            document.getElementById("days").innerText = "00";
            document.getElementById("hours").innerText = "00";
            document.getElementById("minutes").innerText = "00";
            document.getElementById("seconds").innerText = "00";
            return;
          }

          const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
          const hours = Math.floor(
            (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
          );
          const minutes = Math.floor(
            (timeLeft % (1000 * 60 * 60)) / (1000 * 60)
          );
          const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

          document.getElementById("days").innerText = days
            .toString()
            .padStart(2, "0");
          document.getElementById("hours").innerText = hours
            .toString()
            .padStart(2, "0");
          document.getElementById("minutes").innerText = minutes
            .toString()
            .padStart(2, "0");
          document.getElementById("seconds").innerText = seconds
            .toString()
            .padStart(2, "0");
        }

        // Update countdown every second
        setInterval(updateCountdown, 1000);
        updateCountdown();

        // Enhanced Deal category selection with animation
        const categories = document.querySelectorAll(".deal-category");
        categories.forEach((category) => {
          category.addEventListener("click", function () {
            // Add fade effect
            const dealGrid = document.querySelector(".deal-grid");
            dealGrid.style.opacity = "0.6";

            // Update active category
            categories.forEach((c) => c.classList.remove("active"));
            this.classList.add("active");

            // Simulate filtering with a delay for visual effect
            setTimeout(() => {
              dealGrid.style.opacity = "1";
              // In a real implementation, you would filter products here
            }, 300);
          });
        });

        // Add smooth hover effect to deal cards
        const dealCards = document.querySelectorAll(".deal-card");
        dealCards.forEach((card) => {
          card.addEventListener("mouseenter", function () {
            this.style.transition = "transform 0.3s ease, box-shadow 0.3s ease";
          });
        });

        // Newsletter form submission with validation
        const newsletterForm = document.querySelector(".newsletter-form");
        if (newsletterForm) {
          newsletterForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const emailInput = this.querySelector(".newsletter-input");
            const email = emailInput.value.trim();

            if (email && isValidEmail(email)) {
              // Show success message
              emailInput.value = "";
              alert("Thank you for subscribing to our newsletter!");
              // In production, you would send this to your server
            } else {
              alert("Please enter a valid email address.");
            }
          });
        }

        function isValidEmail(email) {
          const re =
            /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
        }
      });
    </script>
  </body>
</html>
