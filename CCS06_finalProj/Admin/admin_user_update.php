<?php
require '../config.php';

$id = $_POST['id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$usertype = $_POST['role'];

if ($id) {
    $query = "UPDATE users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', usertype='$usertype' WHERE id='$id'";
} else {
    $query = "INSERT INTO users (firstname, lastname, username, email, role) VALUES ('$firstname', '$lastname', '$username', '$email', '$usertype')";
}

if ($conn->query($query)) {
    log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'admin', 'admin', 'Update User', "Updated user: $username");
    echo "User updated successfully!";
} else {
    echo "Error: " . $conn->error;
}
?>
