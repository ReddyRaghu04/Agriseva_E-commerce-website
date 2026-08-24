// Global state for products
let allProductsList = [];
let activeCategoryFilter = 'all';
let searchQuery = '';
let currentSort = 'default';

// Fetch products on page load
document.addEventListener('DOMContentLoaded', () => {
  fetchProducts();
});

function fetchProducts() {
  fetch('fetch_php.php')
    .then(res => res.json())
    .then(data => {
      allProductsList = data || [];
      applyFiltersAndRender();
    })
    .catch(err => {
      console.error('Error fetching products:', err);
      const productList = document.getElementById('product-list');
      if (productList) {
        productList.innerHTML = `<div class="col-12 text-center text-muted py-5">
          <h5>Failed to load products</h5>
          <p>Please check your database connection.</p>
        </div>`;
      }
    });
}

// Live Search Input Event Handler
function onLiveSearchInput() {
  const searchInput = document.getElementById('liveSearchInput');
  if (searchInput) {
    searchQuery = searchInput.value.trim().toLowerCase();
    applyFiltersAndRender();
  }
}

// Category Selection Pill Handler
function selectCategory(category, element) {
  activeCategoryFilter = category.toLowerCase();
  
  // Toggle active class on pills
  document.querySelectorAll('.category-pill').forEach(btn => btn.classList.remove('active'));
  if (element) {
    element.classList.add('active');
  }

  applyFiltersAndRender();
}

// Price & Discount Sorting Handler
function onSortChange() {
  const sortSelect = document.getElementById('priceSortSelect');
  if (sortSelect) {
    currentSort = sortSelect.value;
    applyFiltersAndRender();
  }
}

// Combined Filter & Sort Pipeline
function applyFiltersAndRender() {
  let filtered = allProductsList.filter(product => {
    // 1. Category Matching
    const cat = (product.category || '').toLowerCase();
    const sub = (product.subcategory || '').toLowerCase();
    const pName = (product.product_name || '').toLowerCase();
    const pDesc = (product.description || '').toLowerCase();

    let matchesCategory = true;
    if (activeCategoryFilter !== 'all') {
      matchesCategory = cat.includes(activeCategoryFilter) || 
                        sub.includes(activeCategoryFilter) || 
                        pName.includes(activeCategoryFilter);
    }

    // 2. Real-Time Text Search Matching
    let matchesSearch = true;
    if (searchQuery) {
      matchesSearch = pName.includes(searchQuery) || 
                      pDesc.includes(searchQuery) || 
                      cat.includes(searchQuery) || 
                      sub.includes(searchQuery);
    }

    return matchesCategory && matchesSearch;
  });

  // 3. Apply Sorting
  if (currentSort === 'low-high') {
    filtered.sort((a, b) => a.price - b.price);
  } else if (currentSort === 'high-low') {
    filtered.sort((a, b) => b.price - a.price);
  } else if (currentSort === 'discount') {
    filtered.sort((a, b) => {
      const discA = a.previous_price && a.previous_price > a.price ? (a.previous_price - a.price) / a.previous_price : 0;
      const discB = b.previous_price && b.previous_price > b.price ? (b.previous_price - b.price) / b.previous_price : 0;
      return discB - discA;
    });
  }

  // Update badge count
  const badge = document.getElementById('productCountBadge');
  if (badge) {
    badge.textContent = `${filtered.length} Product${filtered.length === 1 ? '' : 's'}`;
  }

  renderProducts(filtered);
}

// Render dynamic product cards into #product-list
function renderProducts(products) {
  const productList = document.getElementById('product-list');
  if (!productList) return;
  
  productList.innerHTML = '';

  if (!products || products.length === 0) {
    productList.innerHTML = `
      <div class="col-12 text-center py-5">
        <div class="p-4 bg-white rounded-4 shadow-sm d-inline-block" style="max-width: 400px;">
          <span class="fs-1">🌾</span>
          <h5 class="fw-bold mt-2 text-dark">No products found</h5>
          <p class="text-muted small mb-0">Try clearing your search query or selecting another category.</p>
        </div>
      </div>`;
    return;
  }

  products.forEach(product => {
    const discount = product.previous_price && product.previous_price > product.price
      ? Math.round(((product.previous_price - product.price) / product.previous_price) * 100)
      : 0;

    const col = document.createElement('div');
    col.className = 'col-lg-4 col-md-6';
    col.innerHTML = `
      <div class="product-card">
        <div class="card-img-wrapper">
          <img src="${product.image}" class="product-image"
               onerror="this.onerror=null; this.src='uploads/default.jpg';" alt="${product.product_name}">
          ${discount > 0 ? `<span class="discount-badge">${discount}% OFF</span>` : ''}
          <span class="category-tag">${product.subcategory || product.category || 'Agri'}</span>
        </div>

        <div class="product-body">
          <h5 class="product-title">${product.product_name}</h5>
          <p class="product-desc">${product.description || 'High quality agricultural input for optimized farming.'}</p>
          
          <div class="price-section">
            <span class="current-price">₹${parseFloat(product.price).toFixed(2)}</span>
            ${product.previous_price && product.previous_price > product.price ? `
              <span class="old-price">₹${parseFloat(product.previous_price).toFixed(2)}</span>
            ` : ''}
          </div>

          <div class="d-flex gap-2 mt-auto">
            <button onclick="window.location.href='checkout_page.php'" class="btn btn-buy flex-grow-1">Buy Now</button>
            <button class="btn btn-cart add_to_cart" data-product-id="${product.id}">+ Cart</button>
          </div>
        </div>
      </div>`;
    
    productList.appendChild(col);
  });
}

// Add to Cart Delegate Event
document.addEventListener("click", function (e) {
  const cartBtn = e.target.closest(".add_to_cart");
  if (cartBtn) {
    const productId = cartBtn.getAttribute("data-product-id");
    if (!productId) return showToast("Missing Product ID", "danger");

    fetch("Add_to_cart.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `product_id=${productId}`
    })
      .then(res => res.text())
      .then(response => showToast(response || "Item added to cart!", "success"))
      .catch(() => showToast("Failed to add item to cart", "danger"));
  }
});

// Toast notification display
function showToast(message, type = "success") {
  let existing = document.getElementById("toastContainer");
  if (existing) existing.remove();

  const toastWrapper = document.createElement("div");
  toastWrapper.id = "toastContainer";
  toastWrapper.className = "position-fixed top-0 start-50 translate-middle-x p-3";
  toastWrapper.style.zIndex = "1090";

  toastWrapper.innerHTML = `
    <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0 show shadow-lg" role="alert" style="border-radius: 14px;">
      <div class="d-flex">
        <div class="toast-body fw-semibold px-3 py-2">🌱 ${message}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>`;

  document.body.appendChild(toastWrapper);

  const toastEl = new bootstrap.Toast(toastWrapper.querySelector(".toast"), { delay: 2500 });
  toastEl.show();

  setTimeout(() => {
    if (toastWrapper) toastWrapper.remove();
  }, 3200);
}

// --- Floating AI Chat Drawer Interaction ---

function toggleAIDrawer() {
  const drawer = document.getElementById('aiDrawer');
  if (drawer) {
    drawer.style.display = drawer.style.display === 'flex' ? 'none' : 'flex';
  }
}

function sendQuickPrompt(promptText) {
  const input = document.getElementById('aiQueryInput');
  if (input) {
    input.value = promptText;
    sendAIQuery();
  }
}

function sendAIQuery() {
  const input = document.getElementById('aiQueryInput');
  const chatBody = document.getElementById('aiChatBody');
  if (!input || !chatBody) return;

  const query = input.value.trim();
  if (!query) return;

  // Render User Message Bubble
  const userBubble = document.createElement('div');
  userBubble.className = 'chat-bubble user';
  userBubble.textContent = query;
  chatBody.appendChild(userBubble);

  input.value = '';
  chatBody.scrollTop = chatBody.scrollHeight;

  // Render Loading Indicator Bubble
  const loadingBubble = document.createElement('div');
  loadingBubble.className = 'chat-bubble ai loading-bubble';
  loadingBubble.innerHTML = '⏳ <i>Agronomist AI analyzing query...</i>';
  chatBody.appendChild(loadingBubble);
  chatBody.scrollTop = chatBody.scrollHeight;

  // Perform AJAX Request to ai_advisory.php
  fetch('ai_advisory.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ query: query })
  })
    .then(res => res.json())
    .then(data => {
      loadingBubble.remove();

      const aiBubble = document.createElement('div');
      aiBubble.className = 'chat-bubble ai';
      
      let formattedAdvice = (data.advice || 'No response received.').replace(/\n/g, '<br>');
      
      let htmlContent = `<div>${formattedAdvice}</div>`;

      // Render Recommended Product Cards in Chat if available
      if (data.recommended_products && data.recommended_products.length > 0) {
        htmlContent += `<div class="mt-3 pt-2 border-top"><b>🛒 Matching Agriseva Products:</b></div>`;
        data.recommended_products.forEach(prod => {
          htmlContent += `
            <div class="d-flex align-items-center justify-content-between p-2 mt-2 bg-light rounded border">
              <div class="d-flex align-items-center gap-2">
                <img src="${prod.image}" onerror="this.src='uploads/default.jpg';" style="width:38px; height:38px; object-fit:cover; border-radius:8px;">
                <div>
                  <div class="fw-bold" style="font-size:0.8rem;">${prod.product_name}</div>
                  <div class="text-success fw-bold" style="font-size:0.78rem;">₹${parseFloat(prod.price).toFixed(2)}</div>
                </div>
              </div>
              <button class="btn btn-sm btn-success add_to_cart px-2 py-1" data-product-id="${prod.id}" style="font-size:0.75rem;">+ Add</button>
            </div>`;
        });
      }

      aiBubble.innerHTML = htmlContent;
      chatBody.appendChild(aiBubble);
      chatBody.scrollTop = chatBody.scrollHeight;
    })
    .catch(err => {
      console.error('AI Advisory Error:', err);
      loadingBubble.remove();
      const errorBubble = document.createElement('div');
      errorBubble.className = 'chat-bubble ai text-danger';
      errorBubble.textContent = '❌ Failed to reach AI Advisor. Please try again.';
      chatBody.appendChild(errorBubble);
    });
}
