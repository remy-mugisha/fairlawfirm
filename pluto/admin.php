<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

echo "Welcome, Admin | <a href='logout.php'>Logout</a>";
?>
