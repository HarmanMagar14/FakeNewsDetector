<?php
session_start();
include '../config.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = intval($_POST['id']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE articles SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    // Log approve/reject
    $action = $status === 'Approved' ? 'Approve Article' : 'Reject Article';
    log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'admin', $_SESSION['usertype'] ?? 'admin', $action, "Article ID: $id");

    echo "success";
} else {
    echo "error";
}
?>