<?php
session_start();
require 'includes/config.php';

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header('Location: unauthorized.php');
    exit;
}

// Validate CSRF token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }

    $user_id = $_POST['user_id'];
    $permissions = $_POST['permissions']; // Array of page names

    // Clear existing permissions
    $stmt = $pdo->prepare('DELETE FROM permissions WHERE user_id = :user_id');
    $stmt->execute(['user_id' => $user_id]);

    // Insert new permissions
    foreach ($permissions as $page_name) {
        $stmt = $pdo->prepare('INSERT INTO permissions (user_id, page_name, can_access) VALUES (:user_id, :page_name, TRUE)');
        $stmt->execute(['user_id' => $user_id, 'page_name' => $page_name]);
    }
    echo 'Permissions updated successfully';
}

$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Permissions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Set Permissions</h2>
    <form action="set_permissions.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
        <div class="form-group">
            <label for="user_id">User</label>
            <select id="user_id" name="user_id" class="form-control">
                <?php
                $users = $pdo->query('SELECT id, username FROM users')->fetchAll();
                foreach ($users as $user) {
                    echo "<option value='{$user['id']}'>{$user['username']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="permissions">Permissions</label>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="page1" name="permissions[]" value="page1">
                <label class="form-check-label" for="page1">Page 1</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="page2" name="permissions[]" value="page2">
                <label class="form-check-label" for="page2">Page 2</label>
            </div>
            <!-- Add more pages as needed -->
        </div>
        <button type="submit" class="btn btn-primary">Set Permissions</button>
    </form>
</div>
</body>
</html>
