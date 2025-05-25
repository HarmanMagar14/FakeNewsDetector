<?php
require '../config.php';

$id = $_POST['id'];
$stmt = $pdo->prepare("DELETE FROM users WHERE id=?");

if ($stmt->execute()) {
    log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'admin', 'admin', 'Delete User', "Deleted user ID: $id");
    echo "User deleted";
}
?>
