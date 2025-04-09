<?php
session_start();

// Only unset the seller session variable
unset($_SESSION['seller_id']);

header("Location: Page.php");
exit();
?>
