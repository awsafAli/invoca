<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $role = $_POST['role'];

    // Validate inputs
    if (empty($username) || empty($password) || empty($email) || empty($role)) {
        die('Please fill in all fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format.');
    }

    // Check if username or email already exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username OR email = :email');
    $stmt->execute(['username' => $username, 'email' => $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        die('Username or email already exists.');
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user
    $stmt = $pdo->prepare('INSERT INTO users (username, password, email, role, created_at) VALUES (:username, :password, :email, :role, NOW())');
    $stmt->execute([
        'username' => $username,
        'password' => $hashedPassword,
        'email' => $email,
        'role' => $role
    ]);

    echo 'User created successfully!';
}
?>
