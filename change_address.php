<?php
session_start();
include 'DB_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$message = "";

// Handle address update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = implode(", ", array_map('trim', [
        $_POST['Hno'], $_POST['village'], $_POST['mandal'], 
        $_POST['district'], $_POST['state'], $_POST['pincode']
    ]));

    $sql = "UPDATE user_details SET address = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $address, $username);
    $message = $stmt->execute() ? "✅ Address updated successfully!" : "❌ Failed to update address.";
    $stmt->close();
}

// Fetch updated address
$sql = "SELECT address FROM user_details WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

// Extract address components
$address_parts = array_pad(explode(", ", $user['address'] ?? ''), 6, '');
list($Hno, $village, $mandal, $district, $state, $pincode) = $address_parts;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Address</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Change Address</h2>
    <?php if ($message) echo "<p class='alert alert-info'>$message</p>"; ?>
    <form method="post">
        <label>H-No:</label>
        <input type="text" name="Hno" class="form-control" value="<?= htmlspecialchars($Hno) ?>" required>

        <label>Village:</label>
        <input type="text" name="village" class="form-control" value="<?= htmlspecialchars($village) ?>" required>

        <label>Mandal:</label>
        <input type="text" name="mandal" class="form-control" value="<?= htmlspecialchars($mandal) ?>" required>

        <label>District:</label>
        <input type="text" name="district" class="form-control" value="<?= htmlspecialchars($district) ?>" required>

        <label>State:</label>
        <input type="text" name="state" class="form-control" value="<?= htmlspecialchars($state) ?>" required>

        <label>Pincode:</label>
        <input type="text" name="pincode" class="form-control" value="<?= htmlspecialchars($pincode) ?>" required>

        <button type="submit" class="btn btn-primary mt-3">Update Address</button>
    </form>

    <a href="checkout_page.php" class="btn btn-secondary mt-3">Back to Checkout</a>
</div>

</body>
</html>
