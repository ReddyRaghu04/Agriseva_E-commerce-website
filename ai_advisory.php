<?php
header('Content-Type: application/json');
error_reporting(0);

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
$query = isset($input['query']) ? trim($input['query']) : (isset($_POST['query']) ? trim($_POST['query']) : '');

if (empty($query)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please provide a farming or crop-related question.'
    ]);
    exit;
}

// Default product pool if DB is offline or empty
$default_products = [
    [
        'id' => 101,
        'product_name' => 'Hybrid Paddy Seeds (BMT-45)',
        'description' => 'High-germination, disease-resistant hybrid paddy seeds producing high yield per acre.',
        'image' => 'Home_image_22.jpg',
        'price' => 850.00,
        'category' => 'seeds',
        'subcategory' => 'Paddy Seeds'
    ],
    [
        'id' => 102,
        'product_name' => 'BT Cotton Seeds Super-Guard',
        'description' => 'Bollworm-resistant BT cotton seeds ideal for dryland and irrigated soil.',
        'image' => 'Home_image_3.jpg',
        'price' => 1200.00,
        'category' => 'seeds',
        'subcategory' => 'Cotton Seeds'
    ],
    [
        'id' => 103,
        'product_name' => 'AgriShield Broad-Spectrum Insecticide',
        'description' => 'Fast-acting foliar insecticide spray targeting caterpillars, whiteflies, and aphids.',
        'image' => 'Agriseva_icon.png',
        'price' => 450.00,
        'category' => 'insecticides',
        'subcategory' => 'Insecticide'
    ],
    [
        'id' => 104,
        'product_name' => 'Bio-Fertilizer Soil Vitalizer (5kg)',
        'description' => 'Organic NPK micro-nutrient bio-fertilizer for enhanced root development.',
        'image' => 'agriseva_bg_image.jpg',
        'price' => 620.00,
        'category' => 'fertilizers',
        'subcategory' => 'Fertilizer'
    ]
];

$all_products = [];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agriseva";

$conn = @new mysqli($servername, $username, $password, $dbname);

if (!$conn->connect_error) {
    $products_result = $conn->query("SELECT id, product_name, description, image, price, previous_price, category, subcategory FROM products_details");
    if ($products_result && $products_result->num_rows > 0) {
        while ($row = $products_result->fetch_assoc()) {
            $all_products[] = $row;
        }
    }
    $conn->close();
}

if (empty($all_products)) {
    $all_products = $default_products;
}

// Prompt Engineering Knowledge Base & Agronomic Diagnostic Logic
$query_lower = strtolower($query);
$recommended = [];
$advice_parts = [];

// 1. Insecticide / Pest Attack Diagnosis
if (preg_match('/(insect|pest|worm|caterpillar|bug|yellow|hole|leaf|leaves|infestation|damage|spray|chemical)/i', $query_lower)) {
    $advice_parts[] = "🌱 **Symptom & Pest Analysis:** The symptoms described indicate a possible pest attack or foliar insect infestation affecting crop leaf vigor.";
    $advice_parts[] = "🔍 **Agronomist Recommendation:** Apply targeted insecticide sprays during early morning or late evening hours for maximum absorption and safety.";
    $advice_parts[] = "💡 **Recommended Agriseva Care Items:** Here are tested crop protection items available on Agriseva:";
    
    foreach ($all_products as $p) {
        $cat = strtolower($p['category'] ?? '');
        $pName = strtolower($p['product_name'] ?? '');
        $pDesc = strtolower($p['description'] ?? '');

        if ($cat === 'insecticides' || str_contains($pName, 'insecticide') || str_contains($pDesc, 'insect') || str_contains($pName, 'shield')) {
            $recommended[] = $p;
        }
    }
} 
// 2. Seeds / Sowing / Varieties Diagnosis
elseif (preg_match('/(seed|seeds|sow|sowing|yield|paddy|cotton|variety|germination|crop)/i', $query_lower)) {
    $advice_parts[] = "🌾 **Seed & Crop Variety Selection:** Choosing certified, high-germination hybrid seeds is essential for maximizing yield per acre.";
    $advice_parts[] = "🔍 **Agronomist Recommendation:** Ensure proper seed treatment before sowing and maintain optimum field irrigation during early germination.";
    $advice_parts[] = "💡 **Recommended Agriseva Certified Seeds:** Check out these top seed varieties in our catalog:";
    
    foreach ($all_products as $p) {
        $cat = strtolower($p['category'] ?? '');
        $sub = strtolower($p['subcategory'] ?? '');
        $pName = strtolower($p['product_name'] ?? '');

        if ($cat === 'seeds' || str_contains($pName, 'seed') || str_contains($sub, 'seed')) {
            $recommended[] = $p;
        }
    }
}
// 3. General Fertilizer / Growth Booster Diagnosis
else {
    $advice_parts[] = "🌿 **General Agriculture & Crop Health Guidance:** Healthy soil nutrition and balanced fertilizer application improve overall plant vitality.";
    $advice_parts[] = "🔍 **Agronomist Recommendation:** Conduct a soil nutrient test to determine NPK balance. Maintain proper irrigation schedule.";
    $advice_parts[] = "💡 **Featured Agriseva Agricultural Products:** Here are top recommended inputs from our marketplace:";
    
    $recommended = array_slice($all_products, 0, 3);
}

// Fallback if empty
if (empty($recommended)) {
    $recommended = array_slice($all_products, 0, 2);
}

$advice = implode("\n\n", $advice_parts);

echo json_encode([
    'status' => 'success',
    'query' => $query,
    'advice' => $advice,
    'recommended_products' => array_values($recommended)
]);
?>
