<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NVIDIA RTX 4070 12GB GDDR6X - TechHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
      .product-detail-page {
        padding: 40px 0;
      }
      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
      }
      .breadcrumbs {
        margin-bottom: 20px;
        font-size: 0.9em;
        color: #555;
      }
      .breadcrumbs a {
        color: #007bff;
        text-decoration: none;
      }
      .breadcrumbs span {
        margin: 0 5px;
      }
      .product-detail-container {
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
        margin-bottom: 40px;
      }
      .product-gallery {
        flex: 1 1 45%;
      }
      .product-info-main {
        flex: 1 1 50%;
      }
      .main-image img {
        width: 100%;
        max-width: 500px;
        border: 1px solid #eee;
        border-radius: 8px;
        display: block;
        margin: 0 auto 15px auto;
      }
      .thumbnail-images {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
      }
      .thumbnail-wrapper {
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
      }
      .thumbnail-images img {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        transition: border-color 0.3s ease;
      }
      .thumbnail-images img.active,
      .thumbnail-images img:hover {
        border-color: #007bff;
      }
      .thumbnail-placeholder {
        cursor: default;
      }

      .product-info-main h1 {
        font-size: 2em;
        margin-bottom: 10px;
      }
      .product-meta {
        font-size: 0.9em;
        color: #666;
        margin-bottom: 15px;
      }
      .product-meta a {
        color: #007bff;
        text-decoration: none;
      }
      .product-meta span {
        margin: 0 5px;
      }
      .product-ratings {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
      } /* Reuse from index */
      .product-ratings .fa-star,
      .product-ratings .fa-star-half-alt {
        color: #ffc107;
      }
      .product-ratings .rating-count {
        margin-left: 8px;
        font-size: 0.9em;
        color: #555;
      }
      .product-price {
        margin-bottom: 20px;
        font-size: 1.2em;
      } /* Reuse from index */
      .product-price .current-price {
        font-size: 1.5em;
        font-weight: bold;
        color: #e63946;
        margin-right: 10px;
      }
      .product-price .old-price {
        text-decoration: line-through;
        color: #aaa;
        font-size: 1.1em;
      }
      .product-availability {
        margin-bottom: 20px;
        font-weight: bold;
      }
      .availability-in-stock {
        color: #2a9d8f;
      }
      .availability-out-stock {
        color: #e63946;
      }
      .short-description {
        margin-bottom: 25px;
        line-height: 1.6;
        color: #555;
      }
      .quantity-selector {
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
      }
      .quantity-selector label {
        font-weight: bold;
      }
      .quantity-input {
        width: 60px;
        text-align: center;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
      }
      .product-actions-main {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
      }
      .product-actions-main .add-to-cart-btn {
        /* Reuse from index */
        padding: 12px 25px;
        font-size: 1em;
        cursor: pointer;
      }
      .product-actions-main .action-btn {
        background: none;
        border: 1px solid #ccc;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
      }
      .product-actions-main .action-btn:hover {
        background-color: #f0f0f0;
        border-color: #aaa;
      }
      .product-actions-main .action-btn i {
        margin-right: 5px;
      }

      .product-details-tabs {
        border-top: 1px solid #eee;
        padding-top: 30px;
        margin-bottom: 40px;
      }
      .tab-navigation {
        display: flex;
        gap: 10px;
        border-bottom: 1px solid #eee;
        margin-bottom: 25px;
      }
      .tab-btn {
        padding: 10px 20px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-size: 1.1em;
        color: #555;
        transition: all 0.3s ease;
      }
      .tab-btn.active,
      .tab-btn:hover {
        color: #007bff;
        border-bottom-color: #007bff;
      }
      .tab-content {
        display: none;
        line-height: 1.7;
      }
      .tab-content.active {
        display: block;
      }
      .spec-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
      }
      .spec-table th,
      .spec-table td {
        border: 1px solid #eee;
        padding: 10px 15px;
        text-align: left;
      }
      .spec-table th {
        background-color: #f8f8f8;
        width: 30%;
      }
      .reviews-summary {
        margin-bottom: 30px;
      }
      .review-list {
        display: flex;
        flex-direction: column;
        gap: 25px;
      }
      .review-item {
        border-bottom: 1px dashed #eee;
        padding-bottom: 20px;
      }
      .review-item:last-child {
        border-bottom: none;
      }
      .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
      }
      .review-author {
        font-weight: bold;
      }
      .review-time {
        font-size: 0.85em;
        color: #888;
      }
      .review-body {
        color: #555;
      }

      /* Reusing product grid styles from index.php for related products */
      .related-products-section {
        background-color: #f9f9f9;
        padding: 40px 0;
      }

      /* Ensure footer styling is consistent (should be in style.css) */
      .footer {
      }

      /* Add to cart notification styles */
      .add-to-cart-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #fff;
        border-left: 4px solid #27ae60;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        z-index: 1000;
        display: flex;
        align-items: center;
        max-width: 350px;
        animation: slideIn 0.3s ease-out;
      }

      .notification-content {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
      }

      .notification-content i {
        color: #27ae60;
        font-size: 1.2em;
        margin-bottom: 5px;
      }

      .notification-content p {
        margin: 0 0 10px 0;
      }

      .view-cart-btn {
        display: inline-block;
        background-color: #1a237e;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.9em;
        align-self: flex-start;
      }

      .close-notification {
        background: none;
        border: none;
        font-size: 1.2em;
        cursor: pointer;
        color: #666;
        margin-left: 10px;
      }

      .fade-out {
        animation: fadeOut 0.5s ease-out forwards;
      }

      @keyframes slideIn {
        from {
          transform: translateX(100%);
          opacity: 0;
        }
        to {
          transform: translateX(0);
          opacity: 1;
        }
      }

      @keyframes fadeOut {
        from {
          opacity: 1;
        }
        to {
          opacity: 0;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php include "header.html"; ?>

    <!-- Main Product Detail Section -->
    <main class="product-detail-page">
      <div class="container">
        <nav class="breadcrumbs">
          <a href="index.php">Home</a> <span>›</span>
          <a href="#">Components</a> <span>›</span>
          <a href="#">Graphics Cards</a> <span>›</span>
          NVIDIA RTX 4070 12GB GDDR6X
        </nav>

        <!-- Product Core Details -->
        <div class="product-detail-container">
          <!-- Product Gallery -->
          <div class="product-gallery">
            <div class="main-image" id="main-image-container">
              <img
                src="img/81E3tQNSq7L._AC_SL1500_.jpg"
                alt="NVIDIA RTX 4070 Main Image"
                id="main-product-image"
                onerror="this.onerror=null; this.style.display='none'; document.getElementById('no-image-placeholder').style.display='flex';"
              />
              <div
                id="no-image-placeholder"
                style="
                  display: none;
                  width: 100%;
                  height: 300px;
                  flex-direction: column;
                  align-items: center;
                  justify-content: center;
                  background: #f8f9fa;
                  border-radius: 8px;
                "
              >
                <i
                  class="fas fa-image"
                  style="font-size: 48px; margin-bottom: 10px; color: #6c757d"
                ></i>
                <span style="font-size: 14px; color: #6c757d"
                  >No Image Available</span
                >
              </div>
            </div>
            <div class="thumbnail-images">
              <div class="thumbnail-wrapper">
                <img
                  src="img/815b3+qj0wL._AC_SL1500_.jpg"
                  alt="RTX 4070 Thumbnail 1"
                  class="active"
                  data-image="img/815b3+qj0wL._AC_SL1500_.jpg"
                  onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                />
                <div
                  class="thumbnail-placeholder"
                  style="
                    display: none;
                    width: 80px;
                    height: 60px;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    background: #f8f9fa;
                    border-radius: 4px;
                    border: 1px solid #ddd;
                  "
                >
                  <i
                    class="fas fa-image"
                    style="font-size: 16px; color: #6c757d"
                  ></i>
                </div>
              </div>
              <div class="thumbnail-wrapper">
                <img
                  src="img/81GyQ70aigL._AC_SL1500_.jpg"
                  alt="RTX 4070 Thumbnail 2"
                  data-image="img/81GyQ70aigL._AC_SL1500_.jpg"
                  onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                />
                <div
                  class="thumbnail-placeholder"
                  style="
                    display: none;
                    width: 80px;
                    height: 60px;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    background: #f8f9fa;
                    border-radius: 4px;
                    border: 1px solid #ddd;
                  "
                >
                  <i
                    class="fas fa-image"
                    style="font-size: 16px; color: #6c757d"
                  ></i>
                </div>
              </div>
              <div class="thumbnail-wrapper">
                <img
                  src="img/81hp6vpk35L._AC_SL1500_.jpg"
                  alt="RTX 4070 Thumbnail 3"
                  data-image="img/81hp6vpk35L._AC_SL1500_.jpg"
                  onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                />
                <div
                  class="thumbnail-placeholder"
                  style="
                    display: none;
                    width: 80px;
                    height: 60px;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    background: #f8f9fa;
                    border-radius: 4px;
                    border: 1px solid #ddd;
                  "
                >
                  <i
                    class="fas fa-image"
                    style="font-size: 16px; color: #6c757d"
                  ></i>
                </div>
              </div>
              <div class="thumbnail-wrapper">
                <img
                  src="img/81JPZdpeH+L._AC_SL1500_.jpg"
                  alt="RTX 4070 Thumbnail 4"
                  data-image="img/81JPZdpeH+L._AC_SL1500_.jpg"
                  onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                />
                <div
                  class="thumbnail-placeholder"
                  style="
                    display: none;
                    width: 80px;
                    height: 60px;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    background: #f8f9fa;
                    border-radius: 4px;
                    border: 1px solid #ddd;
                  "
                >
                  <i
                    class="fas fa-image"
                    style="font-size: 16px; color: #6c757d"
                  ></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Product Information -->
          <div class="product-info-main">
            <h1>NVIDIA RTX 4070 12GB GDDR6X Graphics Card</h1>
            <div class="product-meta">
              Brand: <a href="#">NVIDIA</a>
              <span>|</span> Category:
              <a href="#">Graphics Cards</a> <span>|</span>
              SKU: NV-RTX4070-12G
            </div>
            <div class="product-ratings">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
              <span class="rating-count">(128 Reviews)</span>
            </div>
            <div class="product-price">
              <span class="current-price">$599.99</span>
              <span class="old-price">$649.99</span>
              <!-- Optional: Savings Badge -->
              <!-- <span class="sale-badge">-8%</span> -->
            </div>
            <div class="product-availability">
              <span class="availability-in-stock"
                ><i class="fas fa-check-circle"></i> In Stock</span
              >
              <!-- Or: <span class="availability-out-stock"><i class="fas fa-times-circle"></i> Out of Stock</span> -->
            </div>
            <p class="short-description">
              Experience ultra-performance gaming and creating with the NVIDIA
              GeForce RTX 4070. Built with the ultra-efficient NVIDIA Ada
              Lovelace architecture. Experience fast ray tracing, AI-accelerated
              performance with DLSS 3, new ways to create, and much more.
            </p>

            <!-- Optional: Variations (e.g., Color, Model) -->
            <!-- <div class="product-variations"> ... </div> -->

            <div class="quantity-selector">
              <label for="quantity">Quantity:</label>
              <input
                type="number"
                id="quantity"
                name="quantity"
                class="quantity-input"
                value="1"
                min="1"
                max="10"
                aria-label="Quantity"
              />
            </div>

            <div class="product-actions-main">
              <button class="add-to-cart-btn primary-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
              <button
                class="action-btn add-to-wishlist"
                title="Add to Wishlist"
              >
                <i class="fas fa-heart"></i> Add to Wishlist
              </button>
              <button class="action-btn add-to-compare" title="Compare">
                <i class="fas fa-exchange-alt"></i> Compare
              </button>
            </div>

            <!-- Optional: Short highlights/features list -->
            <ul class="feature-highlights">
              <li>
                <i class="fas fa-check"></i> NVIDIA Ada Lovelace Architecture
              </li>
              <li><i class="fas fa-check"></i> 12GB GDDR6X Memory</li>
              <li><i class="fas fa-check"></i> DLSS 3 Technology</li>
              <li><i class="fas fa-check"></i> Ray Tracing Cores</li>
            </ul>
          </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="product-details-tabs">
          <div class="tab-navigation">
            <button class="tab-btn active" data-tab="description">
              Description
            </button>
            <button class="tab-btn" data-tab="specifications">
              Specifications
            </button>
          </div>

          <div id="description" class="tab-content active">
            <h3>Product Description</h3>
            <p>
              The NVIDIA® GeForce RTX™ 4070 delivers the ultra performance and
              features that enthusiast gamers and creators demand. Bring your
              games and creative projects to life with ray tracing and
              AI-powered graphics. It's powered by the ultra-efficient NVIDIA
              Ada Lovelace architecture and 12GB of superfast G6X memory.
            </p>
            <h4>Key Features:</h4>
            <ul>
              <li>
                <strong>NVIDIA Ada Lovelace Architecture:</strong> Experience a
                quantum leap in performance, efficiency, and AI-powered
                graphics.
              </li>
              <li>
                <strong>Dedicated Ray Tracing Cores:</strong> Delivers realistic
                and immersive graphics.
              </li>
              <li>
                <strong>NVIDIA DLSS 3:</strong> AI-accelerated performance
                booster.
              </li>
              <li>
                <strong>NVIDIA Reflex:</strong> Low-latency platform for
                competitive gaming.
              </li>
              <li>
                <strong>12GB GDDR6X Memory:</strong> High-speed memory for
                demanding games and applications.
              </li>
              <li>
                <strong>Game Ready & Studio Drivers:</strong> Optimized
                performance and reliability.
              </li>
            </ul>
            <p>
              Perfect for 1440p high-refresh rate gaming, the RTX 4070 offers
              incredible performance in the latest titles. It also accelerates
              creative workflows with faster rendering times and AI-powered
              tools in applications like Adobe Creative Suite, Blender, and
              more.
            </p>
          </div>

          <div id="specifications" class="tab-content">
            <h3>Technical Specifications</h3>
            <table class="spec-table">
              <tbody>
                <tr>
                  <th>GPU Architecture</th>
                  <td>NVIDIA Ada Lovelace</td>
                </tr>
                <tr>
                  <th>CUDA Cores</th>
                  <td>5888</td>
                </tr>
                <tr>
                  <th>Boost Clock</th>
                  <td>2.48 GHz</td>
                </tr>
                <tr>
                  <th>Base Clock</th>
                  <td>1.92 GHz</td>
                </tr>
                <tr>
                  <th>Memory Size</th>
                  <td>12 GB</td>
                </tr>
                <tr>
                  <th>Memory Type</th>
                  <td>GDDR6X</td>
                </tr>
                <tr>
                  <th>Memory Interface</th>
                  <td>192-bit</td>
                </tr>
                <tr>
                  <th>Memory Bandwidth</th>
                  <td>504 GB/s</td>
                </tr>
                <tr>
                  <th>Ray Tracing Cores</th>
                  <td>3rd Generation</td>
                </tr>
                <tr>
                  <th>Tensor Cores</th>
                  <td>4th Generation</td>
                </tr>
                <tr>
                  <th>NVIDIA DLSS</th>
                  <td>3</td>
                </tr>
                <tr>
                  <th>Outputs</th>
                  <td>HDMI 2.1a, 3x DisplayPort 1.4a</td>
                </tr>
                <tr>
                  <th>Max Resolution</th>
                  <td>7680x4320 (8K)</td>
                </tr>
                <tr>
                  <th>Power Connectors</th>
                  <td>1x 16-pin (or 2x 8-pin via adapter)</td>
                </tr>
                <tr>
                  <th>Recommended PSU</th>
                  <td>650W</td>
                </tr>
                <tr>
                  <th>Card Dimensions</th>
                  <td>(Varies by model - e.g., 242mm x 112mm)</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
    <!-- Footer Section -->
    <?php include "footer.html"; ?>

    <!-- Back to top button -->
    <button id="back-to-top" class="back-to-top"><i class="fas fa-arrow-up"></i></button>

    <script src="script.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Get product ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get("id");

        console.log("URL parameters:", Object.fromEntries(urlParams.entries()));
        console.log("Product ID from URL:", productId);

        if (!productId) {
          console.error("No product ID provided in URL");
          alert(
            "Product ID is required. Please select a product from the catalog."
          );
          window.location.href = "desktop.php";
          return;
        }

        // Log the product ID and URL for debugging
        console.log("Current URL:", window.location.href);
        console.log("Loading product with ID:", productId);

        // Fetch product details
        const url = `get_product_details.php?id=${encodeURIComponent(
          productId
        )}`;
        console.log("Fetching product details from:", url);

        fetch(url)
          .then((response) => {
            console.log("Response status:", response.status);
            console.log(
              "Response headers:",
              Object.fromEntries(response.headers.entries())
            );

            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text().then((text) => {
              console.log("Raw response text:", text);
              try {
                const data = JSON.parse(text);
                console.log("Parsed response data:", data);
                return data;
              } catch (e) {
                console.error("JSON parse error:", e);
                console.error("Invalid JSON response:", text);
                throw new Error(
                  "Invalid response from server. Please check the server logs."
                );
              }
            });
          })
          .then((data) => {
            console.log("Processing response data:", data);

            if (!data.success) {
              console.error("Server reported error:", data.message);
              throw new Error(data.message || "Failed to load product details");
            }

            if (!data.product) {
              console.error("No product data in response");
              throw new Error("Product data is missing from the response");
            }

            const product = data.product;
            console.log("Product data to display:", product);

            // Validate required fields
            const requiredFields = [
              "name",
              "brand",
              "category",
              "regular_price",
              "description",
            ];
            const missingFields = requiredFields.filter(
              (field) => !product[field]
            );

            if (missingFields.length > 0) {
              console.error("Missing required fields:", missingFields);
              throw new Error(
                `Product data is incomplete. Missing: ${missingFields.join(
                  ", "
                )}`
              );
            }

            // Update page title
            document.title = `${product.name} - TechHub`;

            // Update breadcrumbs
            const breadcrumbs = document.querySelector(".breadcrumbs");
            breadcrumbs.innerHTML = `
              <a href="index.php">Home</a> <span>›</span>
              <a href="#">Computers</a> <span>›</span>
              <a href="desktop.php">Desktop</a> <span>›</span>
              ${product.name}
            `;

            // Update product images
            const mainImage = document.getElementById("main-product-image");
            const thumbnailContainer =
              document.querySelector(".thumbnail-images");

            if (product.images && product.images.length > 0) {
              mainImage.src = product.images[0];
              mainImage.alt = product.name;

              thumbnailContainer.innerHTML = product.images
                .map(
                  (img, index) => `
                <img src="${img}" alt="${product.name} Thumbnail ${index + 1}" 
                     class="${index === 0 ? "active" : ""}" 
                     data-image="${img}">
              `
                )
                .join("");
            } else {
              mainImage.src = "img/placeholder.jpg";
              mainImage.alt = "No image available";
              thumbnailContainer.innerHTML = "";
            }

            // Update product info
            document.querySelector(".product-info-main h1").textContent =
              product.name;
            document.querySelector(".product-meta").innerHTML = `
              Brand: <a href="brands/${product.brand.toLowerCase()}.php">${
              product.brand
            }</a>
              <span>|</span> Category: <a href="${product.category.toLowerCase()}.php">${
              product.category
            }</a>
            `;

            // Update price
            const priceContainer = document.querySelector(".product-price");
            priceContainer.innerHTML = `
              <span class="current-price">$${product.regular_price}</span>
            `;

            // Update availability
            const availabilityContainer = document.querySelector(
              ".product-availability"
            );
            if (product.quantity > 0) {
              availabilityContainer.innerHTML = `
                <span class="availability-in-stock">
                  <i class="fas fa-check-circle"></i> In Stock
                </span>
              `;
            } else {
              availabilityContainer.innerHTML = `
                <span class="availability-out-stock">
                  <i class="fas fa-times-circle"></i> Out of Stock
                </span>
              `;
            }

            // Update description
            document.querySelector(".short-description").textContent =
              product.description;

            // Update specifications
            const specTable = document.querySelector(".spec-table tbody");
            if (product.specifications) {
              try {
                const specs = JSON.parse(product.specifications);
                specTable.innerHTML = Object.entries(specs)
                  .map(
                    ([key, value]) => `
                    <tr>
                      <th>${key}</th>
                      <td>${value}</td>
                    </tr>
                  `
                  )
                  .join("");
              } catch (e) {
                console.error("Error parsing specifications:", e);
                specTable.innerHTML =
                  '<tr><td colspan="2">No specifications available</td></tr>';
              }
            } else {
              specTable.innerHTML =
                '<tr><td colspan="2">No specifications available</td></tr>';
            }

            // Update features
            const featureHighlights = document.querySelector(
              ".feature-highlights"
            );
            if (product.features && product.features.length > 0) {
              featureHighlights.innerHTML = product.features
                .map(
                  (feature) => `
                  <li><i class="fas fa-check"></i> ${feature}</li>
                `
                )
                .join("");
            } else {
              featureHighlights.innerHTML =
                "<li>No special features listed</li>";
            }

            // Add to cart button handler
            document
              .querySelector(".add-to-cart-btn")
              .addEventListener("click", function (e) {
                e.preventDefault();
                if (product.quantity > 0) {
                  // Get quantity from input
                  const quantity =
                    parseInt(document.getElementById("quantity").value) || 1;

                  // Prepare product data
                  const productData = {
                    id: product.id,
                    name: product.name,
                    price: parseFloat(product.regular_price.replace("$", "")),
                    image: product.images ? product.images[0] : "",
                    specs: product.specifications || "",
                    quantity: quantity,
                  };

                  // Add to cart
                  addToCart(productData);
                } else {
                  alert("This product is currently out of stock.");
                }
              });

            // Add to cart function
            function addToCart(product) {
              // Validate product data
              if (!product.id || !product.name || isNaN(product.price)) {
                console.error("Invalid product data:", product);
                return;
              }

              // Prepare data for API call
              const formData = new FormData();
              formData.append("product_id", product.id);
              formData.append("product_name", product.name);
              formData.append("price", product.price);
              formData.append("image_url", product.image || "");
              formData.append("specs", product.specs || "");
              formData.append("quantity", product.quantity || 1);

              // Send data to server
              fetch("add_to_cart.php", {
                method: "POST",
                body: formData,
              })
                .then((response) => response.json())
                .then((data) => {
                  if (data.success) {
                    // Update cart count in the header
                    const cartCountElements =
                      document.querySelectorAll(".cart-count");
                    cartCountElements.forEach((element) => {
                      element.textContent = data.cart_count;
                      element.style.display =
                        data.cart_count > 0 ? "inline-block" : "none";
                    });

                    // Show success notification
                    showAddToCartConfirmation(product.name);
                  } else {
                    console.error("Failed to add item to cart:", data.message);
                    alert("Failed to add item to cart. Please try again.");
                  }
                })
                .catch((error) => {
                  console.error("Error adding to cart:", error);
                  alert("An error occurred while adding the item to cart.");
                });
            }

            // Show add to cart confirmation
            function showAddToCartConfirmation(productName) {
              // Create notification element
              const notification = document.createElement("div");
              notification.className = "add-to-cart-notification";
              notification.innerHTML = `
                    <div class="notification-content">
                        <i class="fas fa-check-circle"></i>
                        <p>${productName} has been added to your cart</p>
                        <a href="cart.php" class="view-cart-btn">View Cart</a>
                    </div>
                    <button class="close-notification">&times;</button>
                `;

              // Add to document
              document.body.appendChild(notification);

              // Remove after 5 seconds
              setTimeout(() => {
                notification.classList.add("fade-out");
                setTimeout(() => {
                  document.body.removeChild(notification);
                }, 500);
              }, 5000);

              // Close button functionality
              const closeBtn = notification.querySelector(
                ".close-notification"
              );
              closeBtn.addEventListener("click", () => {
                document.body.removeChild(notification);
              });
            }

            // Image gallery interaction
            const thumbnails = document.querySelectorAll(
              ".thumbnail-images img"
            );
            thumbnails.forEach((thumb) => {
              thumb.addEventListener("click", function () {
                if (this.style.display === "none") return; // Skip if image is not visible (error occurred)

                const imagePath = this.getAttribute("data-image");
                mainImage.style.display = ""; // Reset display property
                document.getElementById("no-image-placeholder").style.display =
                  "none"; // Hide placeholder
                mainImage.src = imagePath;

                mainImage.onerror = function () {
                  this.onerror = null;
                  this.style.display = "none";
                  document.getElementById(
                    "no-image-placeholder"
                  ).style.display = "flex";
                };

                thumbnails.forEach((t) => t.classList.remove("active"));
                this.classList.add("active");
              });
            });
          })
          .catch((error) => {
            console.error("Error loading product:", error);
            const errorMessage =
              error.message ||
              "Error loading product details. Please try again later.";
            alert(
              `Error: ${errorMessage}\nPlease check the console for more details.`
            );
            window.location.href = "index.php";
          });
      });
    </script>
  </body>
</html>
