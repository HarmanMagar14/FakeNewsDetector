<?php
include '../config.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=articles_export.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Title', 'Content', 'Source URL', 'Date Published', 'Category', 'Status']);

$result = $conn->query("SELECT id, title, content, source_url, date_published, category, status FROM articles");
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
exit;
?>