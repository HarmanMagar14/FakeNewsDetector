<?php
require '../config.php';
$id = $_POST['id'];
$stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'admin', 'admin', 'Delete Category', "Deleted category ID: $id");
    echo "Category deleted!";
} else echo "Error: " . $stmt->error;
?>