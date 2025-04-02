<?php
include('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Username and Password are required!"]);
        exit();
    }

    $stmt = $conn->prepare("SELECT username, full_name, password FROM user_details WHERE username = ?");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error!"]);
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbUsername, $fullName, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $dbUsername;
            $_SESSION['full_name'] = $fullName;

            echo json_encode(["status" => "success", "message" => "Login Successful!", "redirect" => "Page.php"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid Password!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No user found!"]);
    }

    $stmt->close();
    $conn->close(); // Close database connection
}
?>
