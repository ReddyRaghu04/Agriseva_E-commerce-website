<?php
header('Content-Type: application/json');

// Sample default products fallback
$defaultProducts = [
    [
        'id' => 101,
        'product_name' => 'Hybrid Paddy Seeds (BMT-45)',
        'description' => 'High-germination, disease-resistant hybrid paddy seeds producing high yield per acre.',
        'image' => 'Home_image_22.jpg',
        'price' => 850.00,
        'previous_price' => 1050.00,
        'quantity' => 50,
        'category' => 'seeds',
        'subcategory' => 'Paddy Seeds'
    ],
    [
        'id' => 102,
        'product_name' => 'BT Cotton Seeds Super-Guard',
        'description' => 'Bollworm-resistant BT cotton seeds ideal for dryland and irrigated soil.',
        'image' => 'Home_image_3.jpg',
        'price' => 1200.00,
        'previous_price' => 1450.00,
        'quantity' => 35,
        'category' => 'seeds',
        'subcategory' => 'Cotton Seeds'
    ],
    [
        'id' => 103,
        'product_name' => 'AgriShield Broad-Spectrum Insecticide',
        'description' => 'Fast-acting foliar insecticide spray targeting caterpillars, whiteflies, and aphids.',
        'image' => 'Agriseva_icon.png',
        'price' => 450.00,
        'previous_price' => 550.00,
        'quantity' => 80,
        'category' => 'insecticides',
        'subcategory' => 'Insecticide'
    ],
    [
        'id' => 104,
        'product_name' => 'Bio-Fertilizer Soil Vitalizer (5kg)',
        'description' => 'Organic NPK micro-nutrient bio-fertilizer for enhanced root development.',
        'image' => 'agriseva_bg_image.jpg',
        'price' => 620.00,
        'previous_price' => 750.00,
        'quantity' => 100,
        'category' => 'fertilizers',
        'subcategory' => 'Fertilizer'
    ]
];

// Suppress raw warning output on connection attempt
error_reporting(0);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agriseva";

$conn = @new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Graceful fallback if MySQL is offline
    echo json_encode($defaultProducts);
    exit;
}

$query = "SELECT id, product_name, description, image, price, previous_price, quantity, category, subcategory FROM products_details";
$result = $conn->query($query);

if (!$result) {
    echo json_encode($defaultProducts);
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

if (empty($products)) {
    echo json_encode($defaultProducts);
} else {
    echo json_encode($products);
}
?>
