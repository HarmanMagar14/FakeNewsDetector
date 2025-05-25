<?php
include '../config.php';

// Get all article content
$res = $conn->query("SELECT content FROM articles");
$allContent = '';
while ($row = $res->fetch_assoc()) {
    $allContent .= ' ' . strtolower($row['content']);
}

// Get all fake keywords
$keywords = [];
$res = $conn->query("SELECT keyword FROM fake_keywords");
while ($row = $res->fetch_assoc()) {
    $keywords[] = strtolower($row['keyword']);
}

// Count occurrences
$counts = [];
foreach ($keywords as $kw) {
    $counts[$kw] = substr_count($allContent, $kw);
}
arsort($counts);
$top = array_slice($counts, 0, 10);

header('Content-Type: application/json');
echo json_encode($top);
?>