<?php
session_start();
include 'DB_connection.php';

if (!isset($_SESSION['username'])) {
    die(json_encode(["error" => "User not logged in."]));
}

$username = $_SESSION['username'];

// Handle product removal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_product_id'])) {
    $product_id = intval($_POST['remove_product_id']);
    $sql = "DELETE FROM cart WHERE username = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $product_id);

    echo json_encode(["status" => $stmt->execute() ? "success" : "error"]);
    $stmt->close();
    $conn->close();
    exit;
}

// Fetch cart items
$sql = "SELECT p.id, p.seller_name, p.product_name, p.description, p.image, 
               p.unit, p.quantity, p.price, p.previous_price 
        FROM products_details p
        JOIN cart c ON p.id = c.product_id
        WHERE c.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $row['id'] = (int) $row['id'];
    $row['price'] = (float) $row['price'];
    $row['previous_price'] = isset($row['previous_price']) ? (float) $row['previous_price'] : null;
    $row['image'] = str_replace(" ", "%20", trim($row['image']));
    $cart_items[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .product-card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            height: 100%;
        }
        .product-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 220px;
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">🛒 Your Cart</h2>
    <div id="cart-list" class="row mt-4"></div>
</div>

<!-- ✅ Toast Container: Top-Center -->
<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999">
    <div id="cartToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">Product removed successfully!</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let cartData = <?php echo json_encode($cart_items); ?>;
    let cartList = document.getElementById('cart-list');

    if (cartData.length === 0) {
        cartList.innerHTML = '<p class="text-center">Your cart is empty.</p>';
        return;
    }

    cartData.forEach(product => {
        let discount = product.previous_price && product.previous_price > product.price
            ? Math.round(((product.previous_price - product.price) / product.previous_price) * 100)
            : 0;

        let card = document.createElement('div');
        card.className = 'col-md-4 d-flex';
        card.innerHTML = `
            <div class="card product-card w-100">
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
                        <p><b>₹${parseFloat(product.price).toFixed(2)}</b></p>`}

                    <p class="card-text"><strong>Quantity:</strong> ${product.quantity}</p>
                    <button class="btn btn-warning text-white" onclick="window.location.href='checkout_page.php'">Buy Now</button>
                    <button class="btn btn-danger remove-from-cart" data-product-id="${product.id}">Remove</button>
                </div>
            </div>`;
        cartList.appendChild(card);
    });

    // Remove from cart functionality
    document.querySelectorAll('.remove-from-cart').forEach(button => {
        button.addEventListener('click', function () {
            let productId = this.getAttribute('data-product-id');

            fetch('fetch_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `remove_product_id=${productId}`
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    showToast("Product removed successfully!", "success");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast("Failed to remove product.", "danger");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast("Something went wrong!", "danger");
            });
        });
    });
});

// ✅ Toast Function
function showToast(message, type = "success") {
    const toastEl = document.getElementById("cartToast");
    const toastMsg = document.getElementById("toastMessage");

    toastMsg.textContent = message;
    toastEl.className = `toast align-items-center text-white bg-${type} border-0`;

    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}
</script>

</body>
</html>
