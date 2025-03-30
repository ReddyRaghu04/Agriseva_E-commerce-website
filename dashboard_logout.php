<?php
session_start();
session_destroy();
header("Location: Page.php"); // Redirect to home page
exit();
?>
