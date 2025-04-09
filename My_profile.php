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

// Extract address parts
$address_parts = array_pad(explode(", ", $user['address'] ?? ''), 6, '');
list($Hno, $village, $mandal, $district, $state, $pincode) = $address_parts;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f4f8;
        }
        .sidebar {
            height: 100vh;
            background: #ffffff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            padding: 30px 20px;
        }
        .sidebar h4 {
            margin-bottom: 30px;
            font-weight: bold;
        }
        .sidebar .nav-link {
            padding: 10px 15px;
            border-radius: 8px;
            color: #333;
            margin-bottom: 10px;
            transition: 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #e3f2fd;
            color: #0d6efd;
        }
        .content {
            padding: 40px;
            margin-left: 270px;
        }
        .profile-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar position-fixed">
        <h4>👤 My Account</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link <?= ($section == 'profile') ? 'active' : ''; ?>" href="?section=profile">👨‍💼 Profile Info</a></li>
            <li class="nav-item"><a class="nav-link <?= ($section == 'address') ? 'active' : ''; ?>" href="?section=address">🏠 Address</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?= $message; ?></div>
        <?php endif; ?>

        <?php if ($section == 'profile'): ?>
            <h3>👤 Profile Information</h3>
            <div class="profile-card">
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mobile No</label>
                        <input type="text" name="mobile_no" class="form-control" value="<?= htmlspecialchars($user['mobile_no']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">💾 Save Changes</button>
                </form>
            </div>
        <?php elseif ($section == 'address'): ?>
            <h3>🏠 Manage Address</h3>
            <div class="profile-card">
                <form method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" value="<?= htmlspecialchars($state); ?>"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">District</label>
                            <input type="text" name="district" class="form-control" value="<?= htmlspecialchars($district); ?>"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Mandal</label>
                            <input type="text" name="mandal" class="form-control" value="<?= htmlspecialchars($mandal); ?>"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Village</label>
                            <input type="text" name="village" class="form-control" value="<?= htmlspecialchars($village); ?>"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">House No</label>
                            <input type="text" name="Hno" class="form-control" value="<?= htmlspecialchars($Hno); ?>"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Pincode</label>
                            <input type="text" name="pincode" class="form-control" value="<?= htmlspecialchars($pincode); ?>"></div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">📍 Save Address</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
