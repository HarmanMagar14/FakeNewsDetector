<?php
include '../config.php';
$res = $conn->query("SELECT * FROM categories ORDER BY name ASC");
$categories = [];
while ($row = $res->fetch_assoc()) $categories[] = $row;
echo json_encode($categories);
?>