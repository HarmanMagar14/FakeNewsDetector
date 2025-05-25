<?php
include '../config.php';
$name = trim($_POST['name']);
if ($name) {
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    if ($stmt->execute()) {
        log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'admin', 'admin', 'Create Category', "Created category: $name");
        echo "Category added!";
    } else echo "Error: " . $stmt->error;
} else {
    echo "Category name required.";
}
?>