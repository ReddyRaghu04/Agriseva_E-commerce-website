<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Choose Payment Method</h2>

    <form action="confirm_order.php" method="post">
        <div class="form-check">
            <input type="radio" name="payment_method" value="COD" class="form-check-input" required>
            <label class="form-check-label">💰 Cash on Delivery</label>
        </div>
        <div class="form-check">
            <input type="radio" name="payment_method" value="UPI" class="form-check-input" id="upiOption">
            <label class="form-check-label">📲 UPI (Google Pay, PhonePe, Paytm)</label>
        </div>
        <!--<div id="upiSection" class="mt-3" style="display: none;">
            <p>Scan the QR code or click the UPI link to pay:</p>
            <img src="QR_code.JPG" alt="UPI QR Code" width="200">
            <br>
            <a href="" class="btn btn-primary mt-2">Pay via UPI</a>
        </div>-->

        <div class="form-check">
            <input type="radio" name="payment_method" value="Card" class="form-check-input">
            <label class="form-check-label">💳 Debit/Credit Card</label>
        </div>
        <div class="form-check">
            <input type="radio" name="payment_method" value="Scanner" class="form-check-input" id="scannerOption">
            <label class="form-check-label">📷 Scan QR Code</label>
        </div>

        <div id="qrCodeSection" class="mt-3" style="display: none;">
            <p>Scan the QR code below to complete the payment:</p>
            <img src="QR_code.JPG" alt="QR Code" width="200">
        </div>

        <button type="submit" class="btn btn-success mt-3">Place Order</button>
    </form>

    <a href="checkout_page.php" class="btn btn-secondary mt-3">Back to Checkout</a>
</div>

<script>
    document.getElementById('upiOption').addEventListener('change', function() {
        document.getElementById('upiSection').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('scannerOption').addEventListener('change', function() {
        document.getElementById('qrCodeSection').style.display = this.checked ? 'block' : 'none';
    });
</script>

</body>
</html>
