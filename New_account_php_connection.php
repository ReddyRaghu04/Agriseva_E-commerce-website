<?php
include 'DB_connection.php';
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Personal details
    $full_name = $_POST['full_name'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $state = $_POST['state'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $email = $_POST['email'] ?? '';

    // Business details
    $shop_name = $_POST['shop_name'] ?? '';
    $business_address = $_POST['business_address'] ?? '';
    $business_mobile = $_POST['business_mobile'] ?? '';
    $business_email = $_POST['business_email'] ?? '';
    $category = $_POST['category'] ?? '';
    $gst_number = $_POST['gst_number'] ?? '';
    $pan_number = $_POST['pan_number'] ?? '';

    // Bank details
    $bank_holder_name = $_POST['bank_holder_name'] ?? '';
    $bank_account = $_POST['bank_account'] ?? '';
    $bank_name = $_POST['bank_name'] ?? '';
    $ifsc_code = $_POST['ifsc_code'] ?? '';

    // Handling file uploads safely
    $gst_certificate = isset($_FILES['gst_certificate']) ? $_FILES['gst_certificate']['name'] : '';
    $trade_license = isset($_FILES['trade_license']) ? $_FILES['trade_license']['name'] : '';
    $seed_license = isset($_FILES['seed_license']) ? $_FILES['seed_license']['name'] : '';

    // Move uploaded files to a directory
    $upload_dir = "uploads/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if ($gst_certificate) move_uploaded_file($_FILES['gst_certificate']['tmp_name'], $upload_dir . $gst_certificate);
    if ($trade_license) move_uploaded_file($_FILES['trade_license']['tmp_name'], $upload_dir . $trade_license);
    if ($seed_license) move_uploaded_file($_FILES['seed_license']['tmp_name'], $upload_dir . $seed_license);

    // Prepare SQL query
    $sql = "INSERT INTO sellers_information (full_name, dob, state, mobile, email, shop_name, address, business_mobile, business_email, category, gst_number, pan_number, bank_holder_name, account_number, bank_name, ifsc_code, gst_certificate, trade_license, seed_license) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "sssssssssssssssssss",
            $full_name, $dob, $state, $mobile, $email, 
            $shop_name, $business_address, $business_mobile, $business_email, $category, 
            $gst_number, $pan_number, $bank_holder_name, $bank_account, $bank_name, 
            $ifsc_code, $gst_certificate, $trade_license, $seed_license
        );

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Registration successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "SQL preparation failed: " . $conn->error]);
    }

    $conn->close();
}
?>
