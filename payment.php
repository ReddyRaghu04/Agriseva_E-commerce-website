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
    <title>Choose Payment Method</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .container {
            max-width: 600px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .form-check-label {
            font-size: 1.1rem;
            margin-left: 8px;
        }
        #upiSection, #qrCodeSection {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
        img.qr-img {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">💳 Choose Payment Method</h2>

    <form action="confirm_order.php" method="post">
        <div class="form-check mb-2">
            <input type="radio" name="payment_method" value="COD" class="form-check-input" required>
            <label class="form-check-label">💰 Cash on Delivery</label>
        </div>
        <div class="form-check mb-2">
            <input type="radio" name="payment_method" value="UPI" class="form-check-input" id="upiOption">
            <label class="form-check-label">📲 UPI (Google Pay, PhonePe, Paytm)</label>
        </div>

        <div id="upiSection" class="mt-3" style="display: none;">
            <p>Scan the QR code or click the link to pay via UPI:</p>
            <img src="QR_code.JPG" alt="UPI QR Code" class="qr-img" width="200">
            <br>
            <a href="#" class="btn btn-outline-primary mt-2">Pay via UPI</a>
        </div>

        <div class="form-check mb-2">
            <input type="radio" name="payment_method" value="Card" class="form-check-input">
            <label class="form-check-label">💳 Debit/Credit Card</label>
        </div>
        <div class="form-check mb-2">
            <input type="radio" name="payment_method" value="Scanner" class="form-check-input" id="scannerOption">
            <label class="form-check-label">📷 Scan QR Code</label>
        </div>

        <div id="qrCodeSection" class="mt-3" style="display: none;">
            <p>Scan the QR code below to complete the payment:</p>
            <img src="QR_code.JPG" alt="QR Code" class="qr-img" width="200">
        </div>

        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-success">🛒 Place Order</button>
            <a href="checkout_page.php" class="btn btn-secondary">← Back to Checkout</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('upiOption').addEventListener('change', function () {
        document.getElementById('upiSection').style.display = this.checked ? 'block' : 'none';
        document.getElementById('qrCodeSection').style.display = 'none';
    });

    document.getElementById('scannerOption').addEventListener('change', function () {
        document.getElementById('qrCodeSection').style.display = this.checked ? 'block' : 'none';
        document.getElementById('upiSection').style.display = 'none';
    });

    // Hide both on any other selection
    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', function () {
            if (!['UPI', 'Scanner'].includes(this.value)) {
                document.getElementById('upiSection').style.display = 'none';
                document.getElementById('qrCodeSection').style.display = 'none';
            }
        });
    });
</script>

</body>
</html>
