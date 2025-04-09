<?php
// Start session and include DB
session_start();
include 'DB_connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_POST['seller_id'];
    $seller_name = $_POST['seller_name'];
    $product_name = $_POST['product_name'];
    $product_category = $_POST['category'];
    $product_subcategory = $_POST['subcategory'];
    $product_description = $_POST['product_description'];
    $unit = $_POST['unit'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Upload settings
    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION));
    $unique_name = uniqid("img_", true) . '.' . $imageFileType;
    $target_file = $target_dir . $unique_name;

    // Validate image
    if ($_FILES["product_image"]["size"] > 5 * 1024 * 1024) {
        echo "<script>alert('File too large! Max size: 5MB');</script>";
        exit;
    }
    

    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "<script>alert('Invalid file type!');</script>";
        exit;
    }

    // Upload image
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO products_details (seller_id, seller_name, product_name, category, subcategory, description, image, unit, quantity, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssd", $seller_id, $seller_name, $product_name, $product_category, $product_subcategory, $product_description, $target_file, $unit, $quantity, $price);

        if ($stmt->execute()) {
            echo "<script>alert('Product added successfully!'); window.location.href='sellers_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error adding product'); window.location.href='Product_adding.php';</script>";
        }
        

        $stmt->close();
    } else {
        echo "<script>alert('Image upload failed!');</script>";
    }

    $conn->close();
}
?>