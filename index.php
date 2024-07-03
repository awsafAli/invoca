<?php
session_start();

// Redirect to dashboard if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: public/dashboard.php');
    exit;
} else {
    header('Location: public/login.php');
    exit;
}
?>
