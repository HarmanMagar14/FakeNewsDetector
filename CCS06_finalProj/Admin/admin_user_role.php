<?php
require '../config.php';

$id = $_POST['id'];
$usertype = $_POST['role']; // 'admin' or 'user'

$stmt = $conn->prepare("UPDATE users SET usertype=? WHERE id=?");
$stmt->bind_param("si", $usertype, $id);
$stmt->execute();

echo "Role changed to $usertype";
?>