<?php
require 'DB_connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['seller_id'])) {
    header("Location: Login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];
$product_id = $_GET['id'] ?? die("Invalid request");

$query = "SELECT * FROM products_details WHERE id = ? AND seller_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc() ?? die("Product not found or unauthorized access");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $new_price = $_POST['price'];
    $current_price = $product['price'];
    $previous_price = $product['previous_price'];
    
    $target_file = !empty($_FILES['product_image']['name']) ? "uploads/" . basename($_FILES['product_image']['name']) : $product['image'];
    if (!empty($_FILES['product_image']['name'])) {
        move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file);
    }
    
    // Ensure previous_price is always updated
    if ($new_price != $current_price) {
        $previous_price = $current_price; // Store current price before updating
    }
    
    $query = "UPDATE products_details SET product_name=?, description=?, price=?, previous_price=?, image=? WHERE id=? AND seller_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssddssi", $product_name, $description, $new_price, $previous_price, $target_file, $product_id, $seller_id);
    
    if ($stmt->execute()) {
        header("Location: sellers_dashboard.php");
        exit();
    } else {
        echo "Update failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Update Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Price (₹)</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" name="product_image" class="form-control">
                <?php if (!empty($product['image'])): ?>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="img-thumbnail mt-2" width="150">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="seller_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
