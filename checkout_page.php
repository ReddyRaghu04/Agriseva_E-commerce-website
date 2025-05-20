<?php
session_start();
include 'DB_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: User_Login.html");
    exit;
}

$username = $_SESSION['username'];

// Fetch user details
$sql = "SELECT full_name, email, mobile_no, address FROM user_details WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 16px;
        }
        .btn-custom {
            background-color: #0d6efd;
            color: white;
            border-radius: 50px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #084298;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">🛒 Checkout</h2>
        <p class="text-muted">Confirm your shipping details before proceeding to payment.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h4 class="mb-3">📍 Shipping Address</h4>
                <p><strong><?= htmlspecialchars($user['full_name']) ?></strong></p>
                <p><?= nl2br(htmlspecialchars($user['address'])) ?></p>
                <p>📞 <?= htmlspecialchars($user['mobile_no']) ?></p>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="change_address.php" class="btn btn-outline-secondary rounded-pill">✏️ Change Address</a>
                    <a href="payment.php" class="btn btn-custom px-4">💳 Proceed to Payment</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
