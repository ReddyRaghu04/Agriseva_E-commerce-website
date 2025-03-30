<?php
require 'DB_connection.php';

// Ensure session is active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if seller is logged in
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}

$seller_id = $_SESSION['seller_id'];

// Fetch products for the logged-in seller
$query = "SELECT * FROM products_details WHERE seller_id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Query preparation failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Seller Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Seller Dashboard</h2>

        <div class="text-end mb-3">
            <a href="Product_adding.php" class="btn btn-success">Add Product</a>
            <a href="dashboard_logout.php" class="btn btn-danger">Logout</a>
        </div>

        <h3>My Products</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price (₹)</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image" width="100"></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php $stmt->close(); ?>
