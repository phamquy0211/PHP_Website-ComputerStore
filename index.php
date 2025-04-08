<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include session check for "Remember Me" functionality
require_once 'session_check.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechHub - Computers & Components</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php include "header.html"; ?>

    <!-- Carousel Section -->
    <div class="carousel-container">
      <div class="carousel-wrapper">
        <div class="carousel-slides">
          <div class="carousel-slide active">
            <div class="carousel-content">
              <div class="carousel-text">
                <h2>GeForce RTX 50 Series Laptops</h2>
                <p>Game Changer</p>
                <a href="#" class="carousel-btn">Shop Now</a>
              </div>
              <div class="carousel-image">
                <img src="img/Laptop5000.jpg" alt="Gaming Laptop" />
              </div>
            </div>
          </div>
          <div class="carousel-slide">
            <div class="carousel-content">
              <div class="carousel-text">
                <h2>GeForce RTX 50 Series</h2>
                <p>Game Changer</p>
                <a href="#" class="carousel-btn">Explore</a>
              </div>
              <div class="carousel-image">
                <img
                  src="img/Capture-ZT-B50900B-10P.png"
                  alt="Premium Laptops"
                />
              </div>
            </div>
          </div>
          <div class="carousel-slide">
            <div class="carousel-content">
              <div class="carousel-text">
                <h2>Nintendo Switch 2</h2>
                <p>AI and Ray Tracing for Next-Level Visuals</p>
                <a href="#" class="carousel-btn">View Deals</a>
              </div>
              <div class="carousel-image">
                <img src="img/Nintendo.jpg" alt="Spring Sale" />
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-controls">
          <button class="carousel-btn-prev">
            <i class="fas fa-chevron-left"></i>
          </button>
          <div class="carousel-indicators">
            <span class="carousel-indicator active"></span>
            <span class="carousel-indicator"></span>
            <span class="carousel-indicator"></span>
          </div>
          <button class="carousel-btn-next">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Best-Selling Products Section -->
    <section class="bestsellers-section">
      <div class="section-container">
        <div class="section-header">
          <h2 class="section-title">Best-Selling Products</h2>
          <a href="#" class="view-all"
            >View All <i class="fas fa-arrow-right"></i
          ></a>
        </div>

        <div class="product-grid">
          <!-- Product Card 1 -->
          <div class="product-card">
            <div class="product-badge">Best Seller</div>
            <div class="product-image">
              <img src="img/NVDIA.jpg" alt="RTX 4070 Graphics Card" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Graphics Cards</div>
              <h3 class="product-name">
                <a href="detailProduct.php">ASUS NVIDIA GeForce RTX 5090 Astral</a>
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span class="rating-count">(128)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$599.99</span>
                <span class="old-price">$649.99</span>
              </div>
              <button class="add-to-cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
            </div>
          </div>

          <!-- Product Card 2 -->
          <div class="product-card">
            <div class="product-badge">Best Seller</div>
            <div class="product-image">
              <img src="img/AMD.jpg" alt="AMD Ryzen 7 7800X3D" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Processors</div>
              <h3 class="product-name">
                <a href="detailProduct.php">AMD Ryzen 7 7800X3D 8-Core</a>
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span class="rating-count">(95)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$429.99</span>
                <span class="old-price">$449.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>

          <!-- Product Card 3 -->
          <div class="product-card">
            <div class="product-badge sale-badge">Sale -15%</div>
            <div class="product-image">
              <img src="img/SAMSUNG.jpg" alt="Samsung 990 Pro 2TB SSD" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Storage</div>
              <h3 class="product-name">
                <a href="detailProduct.php">Samsung 990 Pro 2TB NVMe SSD</a>
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <span class="rating-count">(64)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$169.99</span>
                <span class="old-price">$199.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>

          <!-- Product Card 4 -->
          <div class="product-card">
            <div class="product-badge">Best Seller</div>
            <div class="product-image">
              <img src="img/ASUS.jpg" alt="ASUS ROG Strix Gaming Monitor" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Monitors</div>
              <h3 class="product-name">
                <a href="detailProduct.php">ASUS ROG Strix 27" 1440p 180Hz</a>
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span class="rating-count">(76)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$399.99</span>
                <span class="old-price">$449.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- New Arrivals Section -->
    <section class="new-arrivals-section">
      <div class="section-container">
        <div class="section-header">
          <h2 class="section-title">New Arrivals</h2>
          <a href="#" class="view-all"
            >View All <i class="fas fa-arrow-right"></i
          ></a>
        </div>

        <div class="product-grid">
          <!-- Product Card 1 -->
          <div class="product-card">
            <div class="product-badge new-badge">New</div>
            <div class="product-image">
              <img src="img/Intel.jpg" alt="Intel Core i9-14900K" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Processors</div>
              <h3 class="product-name">
                <a href="detailProduct.php">Intel Core i9-14900K 24-Core</a>
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span class="rating-count">(42)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$579.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>

          <!-- Product Card 2 -->
          <div class="product-card">
            <div class="product-badge new-badge">New</div>
            <div class="product-image">
              <img src="img/mainBoard.png" alt="ASUS ROG Strix X870-E" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Motherboards</div>
              <h3 class="product-name">
                <a href="detailProduct.php"
                  >ASUS ROG Strix X870-E Gaming WiFi</a
                >
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span class="rating-count">(28)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$429.99</span>
                <span class="old-price">$449.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>

          <!-- Product Card 3 -->
          <div class="product-card">
            <div class="product-badge new-badge">New</div>
            <div class="product-image">
              <img src="img/Corsair.jpg" alt="Corsair Dominator RGB DDR5" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Memory (RAM)</div>
              <h3 class="product-name">
                <a href="detailProduct.php"
                  >Corsair Dominator RGB 32GB DDR5-6000</a
                >
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <span class="rating-count">(17)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$189.99</span>
                <span class="old-price">$209.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>

          <!-- Product Card 4 -->
          <div class="product-card">
            <div class="product-badge preorder-badge">Pre-order</div>
            <div class="product-image">
              <img src="img/LgUltra.jpg" alt="LG UltraGear OLED 32" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Monitors</div>
              <h3 class="product-name">
                <a href="detailProduct.php"
                  >LG UltraGear OLED 32" 4K 240Hz</a
                >
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span class="rating-count">(5)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$999.99</span>
                <span class="old-price">$1,099.99</span>
              </div>
              <button class="add-to-cart-btn preorder">
                <i class="fas fa-shopping-cart"></i> Pre-order Now
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Special Offers Section -->
    <section class="special-offers-section">
      <div class="section-container" style="padding-top: 48px">
        <div class="section-header">
          <h2 class="section-title">Special Offers</h2>
          <a href="#" class="view-all"
            >View All <i class="fas fa-arrow-right"></i
          ></a>
        </div>

        <div class="product-grid">
          <!-- Product Card 1 -->
          <div class="product-card">
            <div class="product-badge sale-badge">Sale -25%</div>
            <div class="product-image">
              <img src="img/RazerV2.jpg" alt="Razer Huntsman V2" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Keyboards</div>
              <h3 class="product-name">
                <a href="detailProduct.php"
                  >Razer Huntsman V2 Optical Gaming Keyboard</a
                >
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span class="rating-count">(83)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$149.99</span>
                <span class="old-price">$199.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>

          <!-- Product Card 2 -->
          <div class="product-card">
            <div class="product-badge sale-badge">Sale -20%</div>
            <div class="product-image">
              <img src="img/LianLi.jpg" alt="Lian Li O11 Dynamic EVO" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Cases</div>
              <h3 class="product-name">
                <a href="detailProduct.php">Lian Li O11 Dynamic EVO White</a>
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span class="rating-count">(112)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$119.99</span>
                <span class="old-price">$149.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>

          <!-- Product Card 3 -->
          <div class="product-card">
            <div class="product-badge sale-badge">Sale -30%</div>
            <div class="product-image">
              <img src="img/Logitech.jpg" alt="Logitech G Pro X Superlight" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Mice</div>
              <h3 class="product-name">
                <a href="detailProduct.php"
                  >Logitech G Pro X Superlight Wireless Gaming Mouse</a
                >
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span class="rating-count">(96)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$99.99</span>
                <span class="old-price">$149.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>

          <!-- Product Card 4 -->
          <div class="product-card">
            <div class="product-badge sale-badge">Sale -15%</div>
            <div class="product-image">
              <img src="img/Cooler.jpg" alt="Cooler Master ML360R" />
              <div class="product-actions">
                <button class="quick-view" title="Quick View">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="add-to-wishlist" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
                <button class="add-to-compare" title="Compare">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <div class="product-category">Cooling</div>
              <h3 class="product-name">
                <a href="detailProduct.php"
                  >Cooler Master ML360R RGB AIO Liquid Cooler</a
                >
              </h3>
              <div class="product-ratings">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span class="rating-count">(74)</span>
              </div>
              <div class="product-price">
                <span class="current-price">$129.99</span>
                <span class="old-price">$149.99</span>
              </div>
              <button class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Brand Categories Section -->
    <section class="brand-categories-section">
      <div class="section-container">
        <div class="section-header">
          <h2 class="section-title">Shop by Brand</h2>
          <a href="#" class="view-all"
            >View All <i class="fas fa-arrow-right"></i
          ></a>
        </div>

        <div class="brand-grid">
          <!-- ASUS -->
          <div class="brand-card">
            <a href="#">
              <div class="brand-image">
                <img src="img_logo/logo-asus-png-7165.png" alt="ASUS" />
              </div>
              <div class="brand-name">ASUS</div>
            </a>
          </div>

          <!-- DELL -->
          <div class="brand-card">
            <a href="#">
              <div class="brand-image">
                <img src="img_logo/dell-png-logo-3742.png" alt="DELL" />
              </div>
              <div class="brand-name">DELL</div>
            </a>
          </div>

          <!-- RAZER -->
          <div class="brand-card">
            <a href="#">
              <div class="brand-image">
                <img src="img_logo/31198-2-razer-logo.png" alt="RAZER" />
              </div>
              <div class="brand-name">RAZER</div>
            </a>
          </div>

          <!-- LENOVO -->
          <div class="brand-card">
            <a href="#">
              <div class="brand-image">
                <img src="img_logo/Lenovo-Logo-PNG-Clipart.png" alt="LENOVO" />
              </div>
              <div class="brand-name">LENOVO</div>
            </a>
          </div>

          <!-- ACER -->
          <div class="brand-card">
            <a href="#">
              <div class="brand-image">
                <img src="img_logo/acer-seeklogo.png" alt="ACER" />
              </div>
              <div class="brand-name">ACER</div>
            </a>
          </div>

          <!-- APPLE -->
          <div class="brand-card">
            <a href="#">
              <div class="brand-image">
                <img src="img_logo/png-apple-logo-9711.png" alt="APPLE" />
              </div>
              <div class="brand-name">APPLE</div>
            </a>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>

    <!-- Back to top button -->
    <button id="back-to-top" class="back-to-top">
      <i class="fas fa-arrow-up"></i>
    </button>
    <script src="script.js"></script>
  </body>
</html>
