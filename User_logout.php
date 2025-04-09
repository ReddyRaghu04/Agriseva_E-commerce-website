<?php
session_start();

// Only unset the user session variable
unset($_SESSION['username']);

// Optionally: redirect to homepage or user login page
header("Location: Page.php");
exit();
?>
