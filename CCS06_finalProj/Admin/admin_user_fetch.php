<?php
include '../config.php';

$query = "SELECT id, firstname, lastname, username, email, usertype FROM users ORDER BY id ASC";
$result = $conn->query($query);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
echo json_encode($users);
?>