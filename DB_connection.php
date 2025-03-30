<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seller registration"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<script>alert('Connection failed: " . $conn->connect_error . "');</script>");
}
