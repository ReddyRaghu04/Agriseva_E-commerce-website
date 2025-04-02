<?php
session_start();
include 'DB_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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
</head>
<body>

<div class="container mt-5">
    <h2>Checkout</h2>
    <div class="card p-3">
        <h4>📍 Shipping Address</h4>
        <p><strong><?= htmlspecialchars($user['full_name']) ?></strong></p>
        <p><?= nl2br(htmlspecialchars($user['address'])) ?></p>
        <p>📞 <?= htmlspecialchars($user['mobile_no']) ?></p>
        <a href="change_address.php" class="btn btn-secondary">Change Address</a>
    </div>

    <a href="payment.php" class="btn btn-primary mt-3">Proceed to Payment</a>
</div>

</body>
</html>
