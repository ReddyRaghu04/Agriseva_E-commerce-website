<?php
include('db_connection.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set the response type to JSON
header('Content-Type: application/json');

// Regenerate session ID to prevent session fixation
session_regenerate_id(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Username and Password are required!"]);
        exit();
    }

    // Prepare SQL query to check if username exists
    $stmt = $conn->prepare("SELECT username, full_name, password FROM user_details WHERE username = ?");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error!"]);
        exit();
    }

    // Bind parameters and execute query
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // If username exists, check the password
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbUsername, $fullName, $hashedPassword);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Set session variables on successful login
            $_SESSION['username'] = $dbUsername;
            $_SESSION['full_name'] = $fullName;

            // Return success response with redirect URL
            echo json_encode(["status" => "success", "message" => "Login Successful!", "redirect" => "Page.php"]);
        } else {
            // Return error if password is invalid
            echo json_encode(["status" => "error", "message" => "Invalid Password!"]);
        }
    } else {
        // Return error if username doesn't exist
        echo json_encode(["status" => "error", "message" => "No user found!"]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
