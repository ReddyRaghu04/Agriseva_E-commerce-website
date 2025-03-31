<?php
session_start();
include 'DB_connection.php';

header('Content-Type: application/json'); // Ensure JSON response
header('Access-Control-Allow-Origin: *'); // Allow external requests if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_POST['id'] ?? '';
    $password = $_POST['psw'] ?? '';

    if (empty($seller_id) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Both fields are required!"]);
        exit;
    }

    
    $stmt = $conn->prepare("SELECT password FROM seller_auth WHERE seller_id = ?");
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();


        if ($password === $db_password) {
            $_SESSION["seller_id"] = $seller_id;
            echo json_encode(["status" => "success", "message" => "Login successful!", "redirect" => "sellers_dashboard.php"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Incorrect password!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Seller ID not found!"]);
    }

    $stmt->close();
    $conn->close();
}
?>
