<?php
include 'DB_connection.php'; 

header('Content-Type: application/json');

$query = "SELECT product_name, description, image, price, previous_price, quantity FROM products_details"; // Added previous_price
$result = $conn->query($query);

if (!$result) {
    echo json_encode(["error" => "SQL Error: " . $conn->error]);
    exit;
}

$products = [];

while ($row = $result->fetch_assoc()) {
    // Ensure previous_price is numeric and exists
    $row['price'] = (float) $row['price'];
    $row['previous_price'] = isset($row['previous_price']) ? (float) $row['previous_price'] : null;

    // Fix: Remove extra spaces in filename (if any)
    $row['image'] = trim($row['image']);
    $row['image'] = str_replace(" ", "%20", $row['image']); 

    $products[] = $row;
}

$conn->close();
echo json_encode($products);
?>
