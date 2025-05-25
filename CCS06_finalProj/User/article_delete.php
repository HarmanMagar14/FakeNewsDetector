<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    $query = "DELETE FROM articles WHERE id = $id";
    
    if ($conn->query($query) === TRUE) {
        log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'user', $_SESSION['usertype'] ?? 'user', 'Delete Article', "Article ID: $id");
        echo "Article deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
