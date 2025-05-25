<?php
include '../config.php';

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password, usertype) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $firstname, $lastname, $username, $email, $password, $role);

if ($stmt->execute()) {
    // Log user creation
    $new_user_id = $conn->insert_id;
    log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'admin', 'admin', 'Create User', "Created user: $username");
    echo "User added successfully";
} else {
    echo "Error: " . $stmt->error;
}
?>