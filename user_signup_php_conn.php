<?php
header('Content-Type: application/json'); // Ensure JSON response
include('db_connection.php');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $mobile_no = $_POST['mobile_no'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO user_details (full_name, mobile_no, username, email, password) 
            VALUES ('$full_name', '$mobile_no', '$username', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        $response["status"] = "success";
        $response["message"] = "Signup successful!";
    } else {
        $response["status"] = "error";
        $response["message"] = "Database error: " . $conn->error;
    }
} else {
    $response["status"] = "error";
    $response["message"] = "Invalid request.";
}

echo json_encode($response);
?>
