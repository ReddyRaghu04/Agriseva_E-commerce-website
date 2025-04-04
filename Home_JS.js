
  // Toggle functions
  function toggleCategoryOptions() {
    let categoryContainer = document.getElementById('categoryDropdown');
    categoryContainer.style.display = categoryContainer.style.display === 'flex' ? 'none' : 'flex';
  }

  function toggleSeedOptions() {
    let seedOptions = document.getElementById('seedOptions');
    seedOptions.style.display = seedOptions.style.display === 'flex' ? 'none' : 'flex';
  }

  // Fetch products and render cards
  fetch('fetch_php.php')
    .then(response => response.json())
    .then(data => {
      let productList = document.getElementById('product-list');

      if (data.length === 0) {
        productList.innerHTML = '<p class="text-center">No products available</p>';
        return;
      }

      data.forEach(product => {
        let discount = product.previous_price && product.previous_price > product.price
          ? Math.round(((product.previous_price - product.price) / product.previous_price) * 100)
          : 0;

        let card = document.createElement('div');
        card.className = 'col-md-4';
        card.innerHTML = `
          <div class="card product-card">
            <img src="${product.image}" class="card-img-top product-image" 
              onerror="this.onerror=null; this.src='uploads/default.jpg';" alt="Product Image">
            <div class="card-body">
              <h5 class="card-title">${product.product_name}</h5>
              <p class="card-text">${product.description.substring(0, 100)}...</p>
              ${product.previous_price && product.previous_price > product.price ? `
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
    })
    .catch(error => console.error('Error fetching products:', error));

  // jQuery Add to Cart AJAX
  $(document).on("click", ".add_to_cart", function () {
    var productId = $(this).data("product-id");
    console.log("Product ID Sent:", productId);

    if (!productId) {
      alert("Error: Missing Product ID.");
      return;
    }

    $.ajax({
      url: "Add_to_cart.php",
      type: "POST",
      data: { product_id: productId },
      success: function (response) {
        console.log("Server Response:", response);
        alert(response);
      },
      error: function () {
        alert("Failed to add to cart.");
      }
    });
  });

