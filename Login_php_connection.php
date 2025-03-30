<?php
session_start();
include 'DB_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_POST['id'] ?? '';
    $password = $_POST['psw'] ?? '';

    if (empty($seller_id) || empty($password)) {
        echo "<script>alert('Both fields are required'); window.location.href='login.html';</script>";
        exit;
    }

    // Retrieve password from DB
    $stmt = $conn->prepare("SELECT password FROM seller_auth WHERE seller_id = ?");
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();

        // Check plain text password
        if ($password === $db_password) {
            $_SESSION["seller_id"] = $seller_id;
            echo "<script> window.location.href='sellers_dashboard.php';</script>";
        } else {
            echo "<script>window.location.href='Login.php';</script>";
        }
    } else {
        echo "<script>window.location.href='Login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
