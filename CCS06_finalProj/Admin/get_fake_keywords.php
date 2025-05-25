<?php
include '../config.php';

$keywords = [];
$result = $conn->query("SELECT keyword FROM fake_keywords");
while ($row = $result->fetch_assoc()) {
    $keywords[] = $row['keyword'];
}
header('Content-Type: application/json');
echo json_encode($keywords);
?>