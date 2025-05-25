<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; // Leave empty if no password is set for the root user  
$database = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    echo("Connection failed");
}

// Fetch user profile data
$user_id = $_SESSION['user_id'] ?? 0;
$user = null;
if ($user_id) {
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
    $user = mysqli_fetch_assoc($result);
}

// Activity log function
function log_activity($conn, $user_id, $username, $usertype, $action, $details = '') {
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, username, usertype, action, details) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $username, $usertype, $action, $details);
    $stmt->execute();
}
?>