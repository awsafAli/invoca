<?php
session_start();

// Redirect to dashboard if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
} else {
    header('Location:login.php');
    exit;
}



// Check if the user has the right role (e.g., 'admin' or 'user')
if ($_SERVER['PHP_SELF'] == '/public/upload.php' && $_SESSION['role'] != 'admin') {
    header('Location: ../public/dashboard.php');
    exit;
}
?>
