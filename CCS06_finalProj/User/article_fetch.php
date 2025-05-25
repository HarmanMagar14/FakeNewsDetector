<?php
include '../config.php';

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$where = [];
if ($search) {
    $search = $conn->real_escape_string($search);
    $where[] = "(title LIKE '%$search%' OR content LIKE '%$search%' OR date_published LIKE '%$search%')";
}
if ($status) {
    $status = $conn->real_escape_string($status);
    $where[] = "status = '$status'";
}
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$query = "SELECT * FROM articles $where_sql ORDER BY id ASC";
$result = $conn->query($query);

if (!$result) {
    echo("Error fetching articles: " . $conn->error);
}

$output = "";
while ($row = $result->fetch_assoc()) {
    $output .= "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['title']}</td>
            <td>{$row['content']}</td>
            <td>{$row['category']}</td>
            <td>{$row['date_published']}</td>
            <td>{$row['status']}</td>
            <td>
                <button class='btn btn-warning btn-sm editBtn'
                        data-id='{$row['id']}'
                        data-title='{$row['title']}'
                        data-content='{$row['content']}'
                        data-category='{$row['category']}'
                        data-source_url='{$row['source_url']}'
                        data-status='{$row['status']}'>Edit</button>
                <button class='btn btn-danger btn-sm deleteBtn' data-id='{$row['id']}'>Delete</button>
            </td>
        </tr>";
}

echo $output;
?>