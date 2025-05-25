<?php
include '../config.php';
$id = $_POST['id'];
$name = trim($_POST['name']);
$stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
$stmt->bind_param("si", $name, $id);
if ($stmt->execute()) {
    log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'admin', 'admin', 'Update Category', "Updated category ID: $id to $name");
    echo "Category updated!";
} else echo "Error: " . $stmt->error;
?>