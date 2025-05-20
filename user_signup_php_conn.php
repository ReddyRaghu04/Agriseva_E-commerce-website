<?php
header('Content-Type: application/json');
include('db_connection.php'); // Include the DB connection script

$response = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize inputs
    $full_name = trim($_POST['full_name'] ?? '');
    $mobile_no = trim($_POST['mobile_no'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';

    // Field validations
    if (empty($full_name)) $errors['full_name'] = "Full name is required.";
    if (empty($mobile_no)) $errors['mobile_no'] = "Mobile number is required.";
    elseif (!preg_match('/^\d{10}$/', $mobile_no)) $errors['mobile_no'] = "Mobile number must be exactly 10 digits.";
    
    if (empty($username)) $errors['username'] = "Username is required.";
    if (empty($email)) $errors['email'] = "Email is required.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email format.";
    
    if (empty($password)) $errors['password'] = "Password is required.";
    elseif (strlen($password) < 6) $errors['password'] = "Password must be at least 6 characters.";

    // If there are validation errors, send back the error response
    if (!empty($errors)) {
        $response = ["status" => "error", "errors" => $errors];
    } else {
        // Check if email or username already exists in the database
        $stmt = $conn->prepare("SELECT id FROM user_details WHERE email=? OR username=?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = ["status" => "error", "message" => "Email or Username already exists."];
        } else {
            // Hash the password before saving it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO user_details (full_name, mobile_no, username, email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $full_name, $mobile_no, $username, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $response = ["status" => "success", "message" => "Signup successful!"];
            } else {
                $response = ["status" => "error", "message" => "Database error, please try again later."];
            }
        }
        $stmt->close(); // Close the prepared statement
    }
} else {
    $response = ["status" => "error", "message" => "Invalid request."]; // Handle invalid request method
}

echo json_encode($response); // Output the response as JSON
?>
