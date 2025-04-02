<?php
session_start();
include 'DB_connection.php'; // Ensure this file correctly establishes a DB connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    die("Login required to add to cart.");
}

$username = $_SESSION['username']; // Get username from session
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0; // Convert to integer

// Debugging output (Remove in production)
if ($product_id == 0) {
    die("Error: Invalid Product ID received.");
}

// Check if the product already exists in the cart
$sql_check = "SELECT * FROM cart WHERE username = ? AND product_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("si", $username, $product_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    die("Error: Product is already in your cart.");
}

// Insert into cart
$sql = "INSERT INTO cart (username, product_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $username, $product_id);

if ($stmt->execute()) {
    echo "Product added to cart.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt_check->close();
$stmt->close();
$conn->close();
?>
