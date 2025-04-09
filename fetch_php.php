<?php
include 'DB_connection.php'; 

header('Content-Type: application/json');

// Full query including all necessary fields
$query = "SELECT id, product_name, description, image, price, previous_price, quantity, category, subcategory FROM products_details";
$result = $conn->query($query);

if (!$result) {
    echo json_encode(["error" => "SQL Error: " . $conn->error]);
    exit;
}

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = [
        'id' => (int)$row['id'],
        'product_name' => $row['product_name'],
        'description' => $row['description'],
        'image' => str_replace(" ", "%20", trim($row['image'])),
        'price' => (float)$row['price'],
        'previous_price' => isset($row['previous_price']) ? (float)$row['previous_price'] : null,
        'quantity' => $row['quantity'],
        'category' => $row['category'] ?? '',
        'subcategory' => $row['subcategory'] ?? ''
    ];
}

$conn->close();
echo json_encode($products);
?>
