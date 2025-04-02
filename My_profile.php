<?php
session_start();
include 'DB_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$message = "";
$section = $_GET['section'] ?? 'profile';

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['full_name'], $_POST['mobile_no'])) {
    $full_name = trim($_POST['full_name']);
    $mobile_no = trim($_POST['mobile_no']);
    
    $sql = "UPDATE user_details SET full_name = ?, mobile_no = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $full_name, $mobile_no, $username);
    $message = $stmt->execute() ? "✅ Profile updated successfully!" : "❌ Failed to update profile.";
    $stmt->close();
}

// Handle address update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['state'], $_POST['district'], $_POST['mandal'], $_POST['village'],$_POST['Hno'], $_POST['pincode'])) {
    $address = implode(", ", array_map('trim', [$_POST['Hno'], $_POST['village'], $_POST['mandal'], $_POST['district'], $_POST['state'], $_POST['pincode']]));
    
    $sql = "UPDATE user_details SET address = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $address, $username);
    $message = $stmt->execute() ? "✅ Address updated successfully!" : "❌ Failed to update address.";
    $stmt->close();
}

// Fetch user details
$sql = "SELECT full_name, email, mobile_no, address FROM user_details WHERE username = ?";
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
    <title>My Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .sidebar { width: 250px; height: 100vh; background: #f8f9fa; padding-top: 20px; position: fixed; }
        .content { margin-left: 270px; padding: 20px; }
        .profile-card { max-width: 600px; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background: white; }
        .nav-link { color: black; font-weight: 500; }
        .nav-link.active { background: #e9ecef; font-weight: bold; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h4 class="text-center">👤 My Account</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link <?= ($section == 'profile') ? 'active' : ''; ?>" href="Page.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                </svg>
                    Home
                </a></li>
                <li class="nav-item"><a class="nav-link <?= ($section == 'profile') ? 'active' : ''; ?>" href="?section=profile">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                </svg>
                    Profile Information
                </a></li>
                <li class="nav-item"><a class="nav-link <?= ($section == 'address') ? 'active' : ''; ?>" href="?section=address">Manage Addresses</a></li>
            </ul>
        </div>
        <div class="content">
            <?php if (!empty($message)) echo "<p class='alert alert-info'>$message</p>"; ?>
            <?php if ($section == 'profile'): ?>
                <h2>Profile Information</h2>
                <div class="profile-card">
                    <form method="post">
                        <div class="mb-3"><label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']); ?>">
                        </div>
                        <div class="mb-3"><label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" readonly>
                        </div>
                        <div class="mb-3"><label class="form-label">Mobile No</label>
                            <input type="text" name="mobile_no" class="form-control" value="<?= htmlspecialchars($user['mobile_no']); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    </form>
                </div>
            <?php elseif ($section == 'address'): ?>
                <h2>🏠 Manage Address</h2>
                <div class="profile-card">
                    <form method="post">
                        <div class="mb-3"><label class="form-label">State</label>
                            <input type="text" class="form-control" name="state" value="<?= htmlspecialchars($state); ?>" >
                        </div>
                        <div class="mb-3"><label class="form-label">District</label>
                            <input type="text" class="form-control" name="district" value="<?= htmlspecialchars($district); ?>" >
                        </div>
                        <div class="mb-3"><label class="form-label">Mandal</label>
                            <input type="text" class="form-control" name="mandal" value="<?= htmlspecialchars($mandal); ?>">
                        </div>
                        <div class="mb-3"><label class="form-label">Village</label>
                            <input type="text" class="form-control" name="village" value="<?= htmlspecialchars($village); ?>" >
                        </div>
                        <div class="mb-3"><label class="form-label">H-No</label>
                            <input type="text" class="form-control" name="Hno" value="<?= htmlspecialchars($Hno); ?>" >
                        </div>
                        <div class="mb-3"><label class="form-label">Pincode</label>
                            <input type="text" class="form-control" name="pincode" value="<?= htmlspecialchars($pincode); ?>" >
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Address</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
