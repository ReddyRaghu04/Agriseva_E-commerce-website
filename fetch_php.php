<?php
include 'DB_connection.php'; 

header('Content-Type: application/json');

$query = "SELECT product_name, description, image, price FROM products_details";
$result = $conn->query($query);

if (!$result) {
    echo json_encode(["error" => "SQL Error: " . $conn->error]);
    exit;
}

$products = [];

while ($row = $result->fetch_assoc()) {
    // Fix: Remove extra spaces in filename (if any)
    $row['image'] = trim($row['image']);
    
    // Ensure correct path
    $row['image'] = str_replace(" ", "%20", $row['image']); 
    
    $products[] = $row;
}

$conn->close();
echo json_encode($products);
?>
