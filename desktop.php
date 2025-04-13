<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desktop PCs - TechHub</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="style.css" />
    <style>
      /* Additional styles for desktop page */
      .product-container {
        display: flex;
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
      }

      .filter-sidebar {
        width: 25%;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      }

      .filter-section {
        margin-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 15px;
      }

      .filter-section:last-child {
        border-bottom: none;
      }

      .filter-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
      }

      .filter-content {
        margin-top: 10px;
      }

      .filter-option {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
      }

      .filter-option input {
        margin-right: 8px;
      }

      .filter-option label {
        font-size: 14px;
        color: #4b5563;
      }

      .price-range {
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .price-input {
        width: 80px;
        padding: 5px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
      }

      .products-grid {
        width: 75%;
      }

      .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
      }

      .products-count {
        font-size: 14px;
        color: #6b7280;
      }

      .sort-filter {
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .sort-select {
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        background-color: white;
      }

      .view-options {
        display: flex;
        gap: 5px;
      }

      .view-option {
        width: 32px;
        height: 32px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        background-color: white;
        cursor: pointer;
      }

      .view-option.active {
        background-color: #f3f4f6;
        color: #2563eb;
      }

      .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
      }

      .filter-mobile-toggle {
        display: none;
        font-weight: 600;
        padding: 10px 15px;
        margin-bottom: 15px;
        background-color: #f3f4f6;
        border-radius: 6px;
        width: 100%;
        text-align: left;
        border: 1px solid #d1d5db;
      }

      .filter-mobile-toggle i {
        float: right;
        margin-top: 3px;
      }

      .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
      }

      .filter-tag {
        background-color: #e5e7eb;
        border-radius: 16px;
        padding: 5px 10px;
        font-size: 12px;
        display: flex;
        align-items: center;
      }

      .filter-tag i {
        margin-left: 5px;
        cursor: pointer;
      }

      .clear-all {
        font-size: 12px;
        color: #4b5563;
        text-decoration: underline;
        cursor: pointer;
      }

      @media (max-width: 768px) {
        .product-container {
          flex-direction: column;
        }

        .filter-sidebar {
          width: 100%;
          margin-bottom: 20px;
          display: none;
        }

        .products-grid {
          width: 100%;
        }

        .product-grid {
          grid-template-columns: repeat(2, 1fr);
        }

        .filter-mobile-toggle {
          display: block;
        }
      }

      @media (max-width: 480px) {
        .product-grid {
          grid-template-columns: 1fr;
        }

        .products-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 10px;
        }

        .sort-filter {
          width: 100%;
          justify-content: space-between;
        }
      }
      /* Enhanced Pagination Styles */
      .pagination-container {
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
      }

      .pagination a {
        display: flex;
        justify-content: center;
        align-items: center;
        min-width: 36px;
        height: 36px;
        border-radius: 5px;
        background-color: #f8f9fa;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
      }

      .pagination a:hover {
        background-color: #e5e7eb;
      }

      .pagination a.active {
        background-color: #2563eb;
        color: white;
      }

      .pagination a.disabled {
        opacity: 0.5;
        pointer-events: none;
      }

      .pagination-arrow {
        padding: 0 12px;
      }

      .pagination-dots {
        margin: 0 5px;
        color: #6b7280;
      }

      .pagination-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #6b7280;
        font-size: 14px;
      }

      .items-per-page {
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .items-per-page select {
        padding: 6px 10px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        background-color: white;
      }

      @media (max-width: 768px) {
        .pagination-info {
          flex-direction: column;
          gap: 10px;
          align-items: flex-start;
        }
      }

      .quantity-container {
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .quantity-container label {
        font-size: 14px;
        color: #666;
      }

      .quantity-input {
        width: 60px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: center;
      }

      .quantity-input::-webkit-inner-spin-button,
      .quantity-input::-webkit-outer-spin-button {
        opacity: 1;
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php include "header.html"; ?>

    <!-- Page Header -->
    <div class="page-header">
      <div class="container">
        <h1>Desktop</h1>
        <nav class="breadcrumb">
          <a href="index.php">Home</a> /
          <a href="#">Computers</a> /
          <span>Desktop</span>
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <main class="container">
      <!-- Mobile filter toggle -->
      <button class="filter-mobile-toggle" id="filter-toggle">
        Filters <i class="fas fa-filter"></i>
      </button>

      <div class="product-container">
        <!-- Filter Sidebar -->
        <aside class="filter-sidebar" id="filter-sidebar">
          <h2>Filters</h2>

          <!-- Active Filters -->
          <div class="active-filters">
            <div class="filter-tag">HP <i class="fas fa-times"></i></div>
            <div class="filter-tag">
              $500 - $1000 <i class="fas fa-times"></i>
            </div>
            <div class="filter-tag">Gaming <i class="fas fa-times"></i></div>
            <span class="clear-all">Clear All</span>
          </div>

          <!-- Price Filter -->
          <div class="filter-section">
            <div class="filter-title">
              Price Range <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-content">
              <div class="price-range">
                <input
                  type="number"
                  class="price-input"
                  placeholder="Min"
                  min="0"
                  value="500"
                />
                <span>to</span>
                <input
                  type="number"
                  class="price-input"
                  placeholder="Max"
                  min="0"
                  value="1000"
                />
              </div>
              <div class="filter-option">
                <input type="checkbox" id="price-1" />
                <label for="price-1">$0 - $499</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="price-2" checked />
                <label for="price-2">$500 - $999</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="price-3" />
                <label for="price-3">$1000 - $1499</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="price-4" />
                <label for="price-4">$1500+</label>
              </div>
            </div>
          </div>

          <!-- Brand Filter -->
          <div class="filter-section">
            <div class="filter-title">
              Brand <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-content">
              <div class="filter-option">
                <input type="checkbox" id="brand-1" checked />
                <label for="brand-1">HP (28)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="brand-2" />
                <label for="brand-2">Dell (22)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="brand-3" />
                <label for="brand-3">Lenovo (18)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="brand-4" />
                <label for="brand-4">ASUS (16)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="brand-5" />
                <label for="brand-5">Acer (14)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="brand-6" />
                <label for="brand-6">MSI (12)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="brand-7" />
                <label for="brand-7">Apple (10)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="brand-8" />
                <label for="brand-8">Alienware (8)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="brand-9" />
                <label for="brand-9">CyberPowerPC (6)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="brand-10" />
                <label for="brand-10">iBUYPOWER (5)</label>
              </div>
            </div>
          </div>

          <!-- Processor Filter -->
          <div class="filter-section">
            <div class="filter-title">
              Processor <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-content">
              <div class="filter-option">
                <input type="checkbox" id="processor-1" />
                <label for="processor-1">Intel Core i3</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="processor-2" />
                <label for="processor-2">Intel Core i5</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="processor-3" />
                <label for="processor-3">Intel Core i7</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="processor-4" />
                <label for="processor-4">Intel Core i9</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="processor-5" />
                <label for="processor-5">AMD Ryzen 3</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="processor-6" />
                <label for="processor-6">AMD Ryzen 5</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="processor-7" />
                <label for="processor-7">AMD Ryzen 7</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="processor-8" />
                <label for="processor-8">AMD Ryzen 9</label>
              </div>
            </div>
          </div>

          <!-- Graphics Card Filter -->
          <div class="filter-section">
            <div class="filter-title">
              Graphics Card <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-content">
              <div class="filter-option">
                <input type="checkbox" id="graphics-1" />
                <label for="graphics-1">NVIDIA GeForce GTX</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="graphics-2" />
                <label for="graphics-2">NVIDIA GeForce RTX</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="graphics-3" />
                <label for="graphics-3">AMD Radeon RX</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="graphics-4" />
                <label for="graphics-4">Intel Integrated</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="graphics-5" />
                <label for="graphics-5">AMD Integrated</label>
              </div>
            </div>
          </div>

          <!-- RAM Filter -->
          <div class="filter-section">
            <div class="filter-title">
              RAM <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-content">
              <div class="filter-option">
                <input type="checkbox" id="ram-1" />
                <label for="ram-1">4GB</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="ram-2" />
                <label for="ram-2">8GB</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="ram-3" />
                <label for="ram-3">16GB</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="ram-4" />
                <label for="ram-4">32GB</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="ram-5" />
                <label for="ram-5">64GB+</label>
              </div>
            </div>
          </div>

          <!-- Storage Filter -->
          <div class="filter-section">
            <div class="filter-title">
              Storage <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-content">
              <div class="filter-option">
                <input type="checkbox" id="storage-1" />
                <label for="storage-1">256GB SSD</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="storage-2" />
                <label for="storage-2">512GB SSD</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="storage-3" />
                <label for="storage-3">1TB SSD</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="storage-4" />
                <label for="storage-4">1TB HDD</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="storage-5" />
                <label for="storage-5">2TB+ HDD</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="storage-6" />
                <label for="storage-6">Hybrid Storage</label>
              </div>
            </div>
          </div>

          <!-- Usage Type Filter -->
          <div class="filter-section">
            <div class="filter-title">
              Usage Type <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-content">
              <div class="filter-option">
                <input type="checkbox" id="usage-1" checked />
                <label for="usage-1">Gaming</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="usage-2" />
                <label for="usage-2">Home/Office</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="usage-3" />
                <label for="usage-3">Content Creation</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="usage-4" />
                <label for="usage-4">Workstation</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="usage-5" />
                <label for="usage-5">Mini/Compact</label>
              </div>
            </div>
          </div>
        </aside>

        <!-- Products Grid -->
        <div class="products-grid">
          <div class="products-header">
            <div class="products-count">Showing 1-12 of 95 products</div>
            <div class="sort-filter">
              <select class="sort-select" aria-label="Sort products">
                <option>Featured</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
                <option>Rating: High to Low</option>
                <option>Newest First</option>
              </select>
              <div class="view-options">
                <button class="view-option active" title="Grid View">
                  <i class="fas fa-th"></i>
                </button>
                <button class="view-option" title="List View">
                  <i class="fas fa-list"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
              <div class="product-badge">Best Seller</div>
              <div class="product-image">
                <img
                  src="/api/placeholder/240/180"
                  alt="HP Pavilion Gaming Desktop"
                />
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
                <div class="product-category">Gaming Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php"
                    >HP Pavilion Gaming Desktop TG01</a
                  >
                </h3>
                <div class="product-ratings">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                  <span class="rating-count">(78)</span>
                </div>
                <div class="product-price">
                  <span class="current-price">$749.99</span>
                  <span class="old-price">$849.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
              <div class="product-badge sale-badge">Sale -15%</div>
              <div class="product-image">
                <img
                  src="/api/placeholder/240/180"
                  alt="Dell XPS Desktop Special Edition"
                />
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
                <div class="product-category">Performance Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php"
                    >Dell XPS Desktop Special Edition</a
                  >
                </h3>
                <div class="product-ratings">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="far fa-star"></i>
                  <span class="rating-count">(54)</span>
                </div>
                <div class="product-price">
                  <span class="current-price">$1,099.99</span>
                  <span class="old-price">$1,299.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
              <div class="product-badge new-badge">New</div>
              <div class="product-image">
                <img
                  src="/api/placeholder/240/180"
                  alt="Lenovo Legion Tower 7i"
                />
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
                <div class="product-category">Gaming Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php"
                    >Lenovo Legion Tower 7i Gaming PC</a
                  >
                </h3>
                <div class="product-ratings">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span class="rating-count">(32)</span>
                </div>
                <div class="product-price">
                  <span class="current-price">$1,799.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
              <div class="product-badge">Best Value</div>
              <div class="product-image">
                <img src="/api/placeholder/240/180" alt="HP Slim Desktop" />
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
                <div class="product-category">Home/Office Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php">HP Slim Desktop PC</a>
                </h3>
                <div class="product-ratings">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="far fa-star"></i>
                  <span class="rating-count">(112)</span>
                </div>
                <div class="product-price">
                  <span class="current-price">$429.99</span>
                  <span class="old-price">$499.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 5 -->
            <div class="product-card">
              <div class="product-badge sale-badge">Sale -10%</div>
              <div class="product-image">
                <img src="/api/placeholder/240/180" alt="ASUS ROG Strix G15" />
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
                <div class="product-category">Gaming Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php"
                    >ASUS ROG Strix G15 Gaming Desktop</a
                  >
                </h3>
                <div class="product-ratings">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                  <span class="rating-count">(45)</span>
                </div>
                <div class="product-price">
                  <span class="current-price">$1,199.99</span>
                  <span class="old-price">$1,349.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 6 -->
            <div class="product-card">
              <div class="product-badge top-badge">Editor's Choice</div>
              <div class="product-image">
                <img
                  src="/api/placeholder/240/180"
                  alt="Alienware Aurora R13"
                />
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
                <div class="product-category">Premium Gaming Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php"
                    >Alienware Aurora R13 Gaming Desktop</a
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
                  <span class="current-price">$2,199.99</span>
                  <span class="old-price">$2,499.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 7 -->
            <div class="product-card">
              <div class="product-badge new-badge">New</div>
              <div class="product-image">
                <img src="/api/placeholder/240/180" alt="Apple Mac Mini M2" />
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
                <div class="product-category">Mini PCs</div>
                <h3 class="product-name">
                  <a href="detailProduct.php">Apple Mac Mini with M2 Chip</a>
                </h3>
                <div class="product-ratings">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span class="rating-count">(36)</span>
                </div>
                <div class="product-price">
                  <span class="current-price">$599.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 8 -->
            <div class="product-card">
              <div class="product-badge">Value Pick</div>
              <div class="product-image">
                <img
                  src="/api/placeholder/240/180"
                  alt="Acer Aspire TC Desktop"
                />
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
                <div class="product-category">Home/Office Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php"
                    >Acer Aspire TC Desktop Computer</a
                  >
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
                  <span class="current-price">$549.99</span>
                  <span class="old-price">$599.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 9 -->
            <div class="product-card">
              <div class="product-badge sale-badge">Sale -12%</div>
              <div class="product-image">
                <img src="/api/placeholder/240/180" alt="MSI MEG Aegis Ti5" />
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
                <div class="product-category">Premium Gaming Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php"
                    >MSI MEG Aegis Ti5 Gaming Desktop</a
                  >
                </h3>
                <div class="product-ratings">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                  <span class="rating-count">(29)</span>
                </div>
                <div class="product-price">
                  <span class="current-price">$2,499.99</span>
                  <span class="old-price">$2,849.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 10 -->
            <div class="product-card">
              <div class="product-badge">Best Value</div>
              <div class="product-image">
                <img
                  src="/api/placeholder/240/180"
                  alt="CyberPowerPC Gamer Xtreme"
                />
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
                <div class="product-category">Gaming Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php"
                    >CyberPowerPC Gamer Xtreme VR</a
                  >
                </h3>
                <div class="product-ratings">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="far fa-star"></i>
                  <span class="rating-count">(83)</span>
                </div>
                <div class="product-price">
                  <span class="current-price">$899.99</span>
                  <span class="old-price">$999.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 11 -->
            <div class="product-card">
              <div class="product-badge new-badge">New Model</div>
              <div class="product-image">
                <img src="/api/placeholder/240/180" alt="HP OMEN 45L" />
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
                <div class="product-category">Premium Gaming Desktops</div>
                <h3 class="product-name">
                  <a href="detailProduct.php">HP OMEN 45L Gaming Desktop</a>
                </h3>
                <div class="product-ratings">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span class="rating-count">(18)</span>
                </div>
                <div class="product-price">
                  <span class="current-price">$1,899.99</span>
                  <span class="old-price">$2,099.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>

            <!-- Product 12 -->
            <div class="product-card">
              <div class="product-badge">Compact</div>
              <div class="product-image">
                <img
                  src="/api/placeholder/240/180"
                  alt="Lenovo IdeaCentre Mini"
                />
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
                <div class="product-category">Mini PCs</div>
                <h3 class="product-name">
                  <a href="detailProduct.php"
                    >Lenovo IdeaCentre Mini 5i Desktop</a
                  >
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
                  <span class="current-price">$549.99</span>
                </div>
                <button class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <nav class="pagination-container" aria-label="Product pagination">
            <div class="pagination">
              <a
                href="#"
                class="pagination-arrow disabled"
                aria-label="Previous page"
                title="Previous page"
              >
                <i class="fas fa-chevron-left"></i>
              </a>
              <a href="#" class="active" aria-current="page">1</a>
              <a href="#" aria-label="Page 2">2</a>
              <a href="#" aria-label="Page 3">3</a>
              <span class="pagination-dots">...</span>
              <a href="#" aria-label="Page 8">8</a>
              <a
                href="#"
                class="pagination-arrow"
                aria-label="Next page"
                title="Next page"
              >
                <i class="fas fa-chevron-right"></i>
              </a>
            </div>
            <div class="pagination-info">
              <span>Showing page 1 of 8</span>
              <div class="items-per-page">
                <label for="items-per-page">Items per page:</label>
                <select
                  id="items-per-page"
                  aria-label="Number of items per page"
                >
                  <option value="12" selected>12</option>
                  <option value="24">24</option>
                  <option value="36">36</option>
                  <option value="48">48</option>
                </select>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </main>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="back-to-top" aria-label="Back to top">
      <i class="fas fa-arrow-up"></i>
    </button>

    <!-- JavaScript -->
    <script src="cart.js"></script>
    <script>
      // Mobile navigation toggle
      const mobileToggle = document.getElementById("mobile-toggle");
      const navLinks = document.getElementById("nav-links");
      const mobileOverlay = document.getElementById("mobile-menu-overlay");

      mobileToggle.addEventListener("click", () => {
        navLinks.classList.toggle("active");
        mobileOverlay.classList.toggle("active");
      });

      mobileOverlay.addEventListener("click", () => {
        navLinks.classList.remove("active");
        mobileOverlay.classList.remove("active");
      });

      // Filter sidebar toggle for mobile
      const filterToggle = document.getElementById("filter-toggle");
      const filterSidebar = document.getElementById("filter-sidebar");

      filterToggle.addEventListener("click", () => {
        filterSidebar.style.display =
          filterSidebar.style.display === "block" ? "none" : "block";
        filterToggle.innerHTML =
          filterSidebar.style.display === "block"
            ? 'Hide Filters <i class="fas fa-times"></i>'
            : 'Filters <i class="fas fa-filter"></i>';
      });

      // Filter sections toggle
      const filterTitles = document.querySelectorAll(".filter-title");

      filterTitles.forEach((title) => {
        title.addEventListener("click", () => {
          const content = title.nextElementSibling;
          content.style.display =
            content.style.display === "none" ? "block" : "none";

          const icon = title.querySelector("i");
          icon.className =
            content.style.display === "none"
              ? "fas fa-chevron-down"
              : "fas fa-chevron-up";
        });
      });

      // View options toggle
      const viewOptions = document.querySelectorAll(".view-option");
      const productGrid = document.querySelector(".product-grid");

      viewOptions.forEach((option) => {
        option.addEventListener("click", () => {
          viewOptions.forEach((opt) => opt.classList.remove("active"));
          option.classList.add("active");

          if (option.querySelector("i").classList.contains("fa-list")) {
            productGrid.classList.add("list-view");
          } else {
            productGrid.classList.remove("list-view");
          }
        });
      });

      // Back to top button
      const backToTopButton = document.getElementById("back-to-top");

      window.addEventListener("scroll", () => {
        if (window.pageYOffset > 300) {
          backToTopButton.style.display = "block";
        } else {
          backToTopButton.style.display = "none";
        }
      });

      backToTopButton.addEventListener("click", () => {
        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });
      });

      document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".product-card .add-to-cart-btn").forEach((button) => {
          button.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productCard = this.closest(".product-card");
            if (!productCard) return;
            const productName = productCard.querySelector(".product-name a").textContent.trim();
            const productId = productCard.querySelector(".product-name a").getAttribute("href").split("=")[1] || Date.now().toString();
            const productImage = productCard.querySelector(".product-image img").src;
            const productSpecs = productCard.querySelector(".product-category") ? 
                                 productCard.querySelector(".product-category").textContent.trim() : "";
            
            // Get and parse the price - check for sale price first
            let price;
            const currentPriceElement = productCard.querySelector(".current-price");
            const oldPriceElement = productCard.querySelector(".old-price");
            
            if (currentPriceElement) {
              const priceText = currentPriceElement.textContent.trim();
              // Remove any currency symbols and commas, then parse to float
              const rawPrice = parseFloat(priceText.replace(/[^0-9.]/g, ""));
              
              if (isNaN(rawPrice)) {
                console.error("Invalid price extracted from:", priceText);
                alert("Error: Could not determine product price. Please try again.");
                return;
              }
              
              // Format price to exactly 2 decimal places as a string
              price = rawPrice.toFixed(2);
            } else {
              console.error("No price element found");
              alert("Error: Could not find product price. Please try again.");
              return;
            }
            
            let quantity = 1;
            const quantityInput = productCard.querySelector(".quantity-input");
            if (quantityInput) {
              quantity = parseInt(quantityInput.value) || 1;
            }
            
            const productData = {
              id: productId,
              name: productName,
              price: price, // price is now a string with exactly 2 decimal places
              image: productImage,
              specs: productSpecs,
              quantity: quantity
            };
            
            // Log the product data for debugging
            console.log("Adding to cart:", productData);
            
            if (typeof window.addToCart === "function") {
              window.addToCart(productData);
            } else {
              console.error("Global addToCart function not found");
              alert("Error adding item to cart. Functionality unavailable.");
            }
          });
        });

        // Load products function
        function loadProducts(page = 1, filters = {}) {
          const queryParams = new URLSearchParams({
            category: "desktop",
            page: page,
            per_page: document.getElementById("items-per-page").value,
            ...filters,
          });

          console.log("Fetching products with params:", queryParams.toString());

          fetch(`get_products.php?${queryParams}`)
            .then((response) => {
              if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
              }
              return response.text().then((text) => {
                try {
                  console.log("Raw response:", text);
                  const data = JSON.parse(text);
                  console.log("Parsed data:", data);
                  return data;
                } catch (e) {
                  console.error("Invalid JSON response:", text);
                  throw new Error("Invalid JSON response from server");
                }
              });
            })
            .then((data) => {
              console.log("Processing data:", data);
              if (data.success) {
                if (data.products && data.products.length > 0) {
                  console.log("Products to display:", data.products);
                  displayProducts(data.products);
                  updatePagination(data.pagination);
                } else {
                  console.log("No products found");
                  const productGrid = document.querySelector(".product-grid");
                  productGrid.innerHTML =
                    '<div class="no-products">No products found</div>';
                }
              } else {
                console.error("Error loading products:", data.message);
                const productGrid = document.querySelector(".product-grid");
                productGrid.innerHTML = `<div class="error-message">Error loading products: ${data.message}</div>`;
              }
            })
            .catch((error) => {
              console.error("Error fetching products:", error);
              const productGrid = document.querySelector(".product-grid");
              productGrid.innerHTML = `<div class="error-message">Error loading products. Please try again later.</div>`;
            });
        }

        // Display products function
        function displayProducts(products) {
          const productGrid = document.querySelector(".product-grid");
          productGrid.innerHTML = "";

          products.forEach((product) => {
            const productCard = createProductCard(product);
            productGrid.appendChild(productCard);
          });
        }

        // Create product card function
        function createProductCard(product) {
          console.log("Creating card for product:", product);
          const card = document.createElement("div");
          card.className = "product-card";

          // Add click handler to the entire card
          card.onclick = () => {
            console.log("Card clicked for product:", product);
            const url = `detailProduct.php?id=${encodeURIComponent(
              product.id
            )}`;
            console.log("Navigating to:", url);
            window.location.href = url;
          };

          // Add product badge if it's new
          if (product.features && product.features.includes("new")) {
            const badge = document.createElement("div");
            badge.className = "product-badge new-badge";
            badge.textContent = "New";
            card.appendChild(badge);
          }

          // Add sale badge if price is discounted
          if (
            product.sale_price &&
            product.sale_price < product.regular_price
          ) {
            const discount = Math.round(
              ((product.regular_price - product.sale_price) /
                product.regular_price) *
                100
            );
            const badge = document.createElement("div");
            badge.className = "product-badge sale-badge";
            badge.textContent = `Sale -${discount}%`;
            card.appendChild(badge);
          }

          // Create product image container
          const imageContainer = document.createElement("div");
          imageContainer.className = "product-image";

          // Add main product image
          const img = document.createElement("img");
          img.src = product.images[0] || "img/placeholder.jpg";
          img.alt = product.name;
          imageContainer.appendChild(img);

          // Add product actions
          const actions = document.createElement("div");
          actions.className = "product-actions";

          // Add quick view button
          const quickViewBtn = document.createElement("button");
          quickViewBtn.className = "quick-view";
          quickViewBtn.title = "Quick View";
          quickViewBtn.innerHTML = '<i class="fas fa-eye"></i>';
          quickViewBtn.onclick = (e) => {
            e.stopPropagation();
            window.location.href = `detailProduct.php?id=${encodeURIComponent(
              product.id
            )}`;
          };

          // Add wishlist button
          const wishlistBtn = document.createElement("button");
          wishlistBtn.className = "add-to-wishlist";
          wishlistBtn.title = "Add to Wishlist";
          wishlistBtn.innerHTML = '<i class="fas fa-heart"></i>';
          wishlistBtn.onclick = (e) => {
            e.stopPropagation();
            // Add to wishlist logic here
            alert("Added to wishlist!");
          };

          // Add compare button
          const compareBtn = document.createElement("button");
          compareBtn.className = "add-to-compare";
          compareBtn.title = "Compare";
          compareBtn.innerHTML = '<i class="fas fa-exchange-alt"></i>';
          compareBtn.onclick = (e) => {
            e.stopPropagation();
            // Add to compare logic here
            alert("Added to compare!");
          };

          actions.appendChild(quickViewBtn);
          actions.appendChild(wishlistBtn);
          actions.appendChild(compareBtn);
          imageContainer.appendChild(actions);
          card.appendChild(imageContainer);

          // Create product info container
          const infoContainer = document.createElement("div");
          infoContainer.className = "product-info";

          // Add category
          const category = document.createElement("div");
          category.className = "product-category";
          category.textContent = product.category;
          infoContainer.appendChild(category);

          // Add product name
          const name = document.createElement("h3");
          name.className = "product-name";
          name.innerHTML = `<a href="detailProduct.php?id=${encodeURIComponent(
            product.id
          )}">${product.name}</a>`;
          infoContainer.appendChild(name);

          // Add ratings
          const ratings = document.createElement("div");
          ratings.className = "product-ratings";
          ratings.innerHTML = `
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
              <span class="rating-count">(${product.rating || 0})</span>
          `;
          infoContainer.appendChild(ratings);

          // Add price
          const priceContainer = document.createElement("div");
          priceContainer.className = "product-price";
          priceContainer.innerHTML = `
              <span class="current-price">$${product.regular_price}</span>
              ${
                product.sale_price
                  ? `<span class="old-price">$${product.regular_price}</span>`
                  : ""
              }
          `;
          infoContainer.appendChild(priceContainer);

          // Add quantity input
          const quantityContainer = document.createElement("div");
          quantityContainer.className = "quantity-container";
          quantityContainer.innerHTML = `
            <label for="quantity-${product.id}">Quantity:</label>
            <input type="number" id="quantity-${product.id}" class="quantity-input" value="1" min="1" max="10">
          `;
          infoContainer.appendChild(quantityContainer);

          // Add to cart button
          const addToCartBtn = document.createElement("button");
          addToCartBtn.className = "add-to-cart-btn";
          addToCartBtn.innerHTML =
            '<i class="fas fa-shopping-cart"></i> Add to Cart';
          addToCartBtn.onclick = (e) => {
            e.preventDefault();
            e.stopPropagation();

            // Get quantity from input
            const quantityInput = document.getElementById(
              `quantity-${product.id}`
            );
            const quantity = quantityInput
              ? parseInt(quantityInput.value) || 1
              : 1;

            // Determine the correct price (use sale price if available and lower)
            let price;
            if (product.sale_price && parseFloat(String(product.sale_price).replace(/[^0-9.]/g, "")) < parseFloat(String(product.regular_price).replace(/[^0-9.]/g, ""))) {
              price = parseFloat(String(product.sale_price).replace(/[^0-9.]/g, ""));
            } else {
              price = parseFloat(String(product.regular_price).replace(/[^0-9.]/g, ""));
            }

            // Log price for debugging
            console.log("Product price:", {
              regular: product.regular_price,
              sale: product.sale_price,
              final: price
            });

            // Prepare product data
            const productData = {
              id: product.id,
              name: product.name,
              price: price,
              image: product.images ? product.images[0] : "",
              specs: product.specifications || "",
              quantity: quantity,
            };

            // Log product data for debugging
            console.log("Adding to cart:", productData);

            // Add to cart using the global function from cart.js
            if (typeof window.addToCart === "function") {
              window.addToCart(productData);
            } else {
              console.error("Global addToCart function not found.");
              alert("Error adding item to cart. Functionality unavailable.");
            }
          };
          infoContainer.appendChild(addToCartBtn);

          card.appendChild(infoContainer);
          return card;
        }

        // Update pagination function
        function updatePagination(pagination) {
          const paginationContainer = document.querySelector(".pagination");
          const paginationInfo = document.querySelector(".pagination-info");

          // Update pagination info
          paginationInfo.innerHTML = `
            <span>Showing page ${pagination.current_page} of ${
            pagination.total_pages
          }</span>
            <div class="items-per-page">
              <label for="items-per-page">Items per page:</label>
              <select id="items-per-page" aria-label="Number of items per page">
                <option value="12" ${
                  pagination.per_page === 12 ? "selected" : ""
                }>12</option>
                <option value="24" ${
                  pagination.per_page === 24 ? "selected" : ""
                }>24</option>
                <option value="36" ${
                  pagination.per_page === 36 ? "selected" : ""
                }>36</option>
                <option value="48" ${
                  pagination.per_page === 48 ? "selected" : ""
                }>48</option>
              </select>
            </div>
          `;

          // Update pagination links
          let paginationHTML = "";

          // Previous button
          paginationHTML += `
            <a href="#" class="pagination-arrow ${
              pagination.current_page === 1 ? "disabled" : ""
            }" 
               data-page="${pagination.current_page - 1}">
              <i class="fas fa-chevron-left"></i>
            </a>
          `;

          // Page numbers
          for (let i = 1; i <= pagination.total_pages; i++) {
            if (
              i === 1 ||
              i === pagination.total_pages ||
              (i >= pagination.current_page - 2 &&
                i <= pagination.current_page + 2)
            ) {
              paginationHTML += `
                <a href="#" class="${
                  i === pagination.current_page ? "active" : ""
                }" 
                   data-page="${i}">${i}</a>
              `;
            } else if (
              i === pagination.current_page - 3 ||
              i === pagination.current_page + 3
            ) {
              paginationHTML += '<span class="pagination-dots">...</span>';
            }
          }

          // Next button
          paginationHTML += `
            <a href="#" class="pagination-arrow ${
              pagination.current_page === pagination.total_pages
                ? "disabled"
                : ""
            }" 
               data-page="${pagination.current_page + 1}">
              <i class="fas fa-chevron-right"></i>
            </a>
          `;

          paginationContainer.innerHTML = paginationHTML;

          // Add click handlers to pagination links
          paginationContainer.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", (e) => {
              e.preventDefault();
              const page = parseInt(e.target.closest("a").dataset.page);
              if (!isNaN(page) && page > 0 && page <= pagination.total_pages) {
                loadProducts(page, getCurrentFilters());
              }
            });
          });
        }

        // Get current filters function
        function getCurrentFilters() {
          const filters = {};

          // Get price range
          const minPrice = document.querySelector(
            '.price-input[placeholder="Min"]'
          ).value;
          const maxPrice = document.querySelector(
            '.price-input[placeholder="Max"]'
          ).value;
          if (minPrice) filters.min_price = minPrice;
          if (maxPrice) filters.max_price = maxPrice;

          // Get selected brands
          const selectedBrands = Array.from(
            document.querySelectorAll("#brand-filter input:checked")
          ).map((input) => input.value);
          if (selectedBrands.length > 0) filters.brand = selectedBrands;

          // Get sort order
          const sortSelect = document.querySelector(".sort-select");
          if (sortSelect) filters.sort = sortSelect.value;

          return filters;
        }

        // Add event listeners for filters
        document.querySelectorAll(".filter-option input").forEach((input) => {
          input.addEventListener("change", () => {
            loadProducts(1, getCurrentFilters());
          });
        });

        document
          .querySelector(".sort-select")
          .addEventListener("change", () => {
            loadProducts(1, getCurrentFilters());
          });

        document
          .getElementById("items-per-page")
          .addEventListener("change", () => {
            loadProducts(1, getCurrentFilters());
          });

        // Initial load
        loadProducts();
      });
    </script>
  </body>
</html>
