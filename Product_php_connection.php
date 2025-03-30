<?php
session_start();
include 'DB_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_POST['seller_id'];
    $seller_name = $_POST['seller_name'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $unit = $_POST['unit'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Handle Image Upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate Image
    if ($_FILES["product_image"]["size"] > 500000) {
        echo "<script>alert('File too large!'); window.location.href='Product_adding.php';</script>";
        exit;
    }
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "<script>alert('Only JPG, JPEG, PNG, & GIF files allowed'); window.location.href='Product_adding.php';</script>";
        exit;
    }
    
    // Move Uploaded File
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        // Insert Data into Database
        $stmt = $conn->prepare("INSERT INTO products_details (seller_id, seller_name, product_name, description, image, unit, quantity, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssd", $seller_id, $seller_name, $product_name, $product_description, $target_file, $unit, $quantity, $price);
        
        if ($stmt->execute()) {
            echo "<script>alert('Product added successfully!'); window.location.href='Product_adding.php';</script>";
        } else {
            echo "<script>alert('Error adding product'); window.location.href='Product_adding.php';</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('File upload failed'); window.location.href='Product_adding.php';</script>";
    }

    $conn->close();
}
?>
