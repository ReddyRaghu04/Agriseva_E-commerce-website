// Toggle dropdowns
function toggleCategoryOptions() {
  const dropdown = document.getElementById('categoryDropdown');
  dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
}

function toggleSeedOptions() {
  const seedOptions = document.getElementById('seedOptions');
  seedOptions.style.display = seedOptions.style.display === 'flex' ? 'none' : 'flex';
}

// Fetch products
fetch('fetch_php.php')
  .then(res => res.json())
  .then(renderProducts)
  .catch(err => console.error('Error fetching products:', err));

// Render product cards
function renderProducts(products) {
  const productList = document.getElementById('product-list');
  productList.innerHTML = '';

  if (!products.length) {
    productList.innerHTML = '<p class="text-center">No products available</p>';
    return;
  }

  products.forEach(product => {
    const discount = product.previous_price && product.previous_price > product.price
      ? Math.round(((product.previous_price - product.price) / product.previous_price) * 100)
      : 0;

    const card = document.createElement('div');
    card.className = 'col-md-4';
    card.innerHTML = `
      <div class="card product-card"
           data-category="${(product.category || '').toLowerCase()}"
           data-subcategory="${(product.subcategory || '').toLowerCase()}">
        <img src="${product.image}" class="card-img-top product-image"
             onerror="this.onerror=null; this.src='uploads/default.jpg';" alt="Product Image">
        <div class="card-body">
          <h5 class="card-title">${product.product_name}</h5>
          <p class="card-text">${product.description.substring(0, 100)}...</p>
          ${discount > 0 ? `
            <p class="text-danger">
              <s>₹${parseFloat(product.previous_price).toFixed(2)}</s> →
              <b>₹${parseFloat(product.price).toFixed(2)}</b>
              <span class="badge bg-success">${discount}% OFF</span>
            </p>` : `
            <p><b>₹${parseFloat(product.price).toFixed(2)}</b></p>`}
          <p class="card-text"><strong>Quantity:</strong> ${product.quantity}</p>
          <button onclick="window.location.href='checkout_page.php'" class="btn text-white" style="background-color: #fd7e14;">Buy Now</button>
          <button class="btn text-white add_to_cart" style="background-color: rgb(227, 227, 54);" data-product-id="${product.id}">Add to Cart</button>
        </div>
      </div>`;
    productList.appendChild(card);
  });
}

// Add to Cart handler using toast
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("add_to_cart")) {
    const productId = e.target.getAttribute("data-product-id");
    if (!productId) return showToast("Missing Product ID", "danger");

    fetch("Add_to_cart.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `product_id=${productId}`
    })
      .then(res => res.text())
      .then(response => showToast(response, "success"))
      .catch(() => showToast("Failed to add to cart", "danger"));
  }
});

// Show toast at top-center
function showToast(message, type = "success") {
  let existing = document.getElementById("toastContainer");
  if (existing) existing.remove();

  const toastWrapper = document.createElement("div");
  toastWrapper.id = "toastContainer";
  toastWrapper.className = "position-fixed top-0 start-50 translate-middle-x p-3";
  toastWrapper.style.zIndex = "1055";

  toastWrapper.innerHTML = `
    <div class="toast align-items-center text-white bg-${type} border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">${message}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>`;

  document.body.appendChild(toastWrapper);

  const toastEl = new bootstrap.Toast(toastWrapper.querySelector(".toast"), { delay: 2000 });
  toastEl.show();

  setTimeout(() => {
    toastWrapper.remove();
  }, 3000);
}

// Filter products by category and/or subcategory
function filterProducts(category = null, subcategory = null) {
  document.querySelectorAll('.product-card').forEach(card => {
    const wrapper = card.closest('.col-md-4');
    const cat = card.dataset.category;
    const sub = card.dataset.subcategory;

    const isMatch =
      (!category || cat === category.toLowerCase()) &&
      (!subcategory || sub === subcategory.toLowerCase());

    wrapper.style.display = isMatch ? 'block' : 'none';
  });

  document.getElementById('categoryDropdown').style.display = 'none';
  document.getElementById('seedOptions').style.display = 'none';
}

// Global access
window.filterProductsByCategory = (category, subcategory = null) => {
  filterProducts(category, subcategory);
};
