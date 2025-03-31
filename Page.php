<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agriseva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            text-align: center;
            background: url('agriseva_bg_image.jpg') no-repeat center center/cover;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .product-card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .category-container {
            display: none;
            flex-direction: column;
            align-items: start;
            gap: 10px;
            margin-top: 10px;
        }
        .seed-options {
            display: none;
            flex-direction: column;
            gap: 5px;
            margin-left: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Agriseva</h1>
    </div>

    <div class="container my-4">
        <div class="d-flex justify-content-between">
            <button class="btn btn-primary" onclick="toggleCategoryOptions()">Select Category</button>
            <a href="Login.php"><button class="btn btn-success">Seller</button></a>
        </div>

        <div class="mt-3">
            <div id="category-container" class="category-container">
                <button class="btn btn-outline-primary" onclick="toggleSeedOptions()">Seeds</button>
                <div id="seed-options" class="seed-options">
                    <button class="btn btn-outline-success">Paddy Seeds</button>
                    <button class="btn btn-outline-success">Cotton Seeds</button>
                </div>
                <button class="btn btn-outline-primary">Insecticides</button>
            </div>
        </div>

        <h2 class="text-center">Available Products</h2>
        <div class="row" id="product-list">
            <!-- Products will be dynamically loaded here -->
        </div>
    </div>

    <script>
        function toggleCategoryOptions() {
            let categoryContainer = document.getElementById('category-container');
            categoryContainer.style.display = categoryContainer.style.display === 'flex' ? 'none' : 'flex';
        }

        function toggleSeedOptions() {
            let seedOptions = document.getElementById('seed-options');
            seedOptions.style.display = seedOptions.style.display === 'flex' ? 'none' : 'flex';
        }

        // Fetch products from backend
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
                                onerror="this.onerror=null; this.src='uploads/default.jpg';" 
                                alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title">${product.product_name}</h5>
                                <p class="card-text">${product.description.substring(0, 100)}...</p>
                                
                                ${product.previous_price && product.previous_price > product.price ? `
                                    <p class="text-danger">
                                        <s>₹${parseFloat(product.previous_price).toFixed(2)}</s> → 
                                        <b>₹${parseFloat(product.price).toFixed(2)}</b> 
                                        <span class="badge bg-success">${discount}% OFF</span>
                                    </p>` : `
                                    <p><b>₹${parseFloat(product.price).toFixed(2)}</b></p>`
                                }

                                <p class="card-text"><strong>Quantity:</strong> ${product.quantity}</p>
                                <button class="btn text-white" style="background-color: #fd7e14;">BUY</button>
                            </div>
                        </div>`;
                    
                    productList.appendChild(card);
                });
            })
            .catch(error => console.error('Error fetching products:', error));
    </script>

</body>
</html>
