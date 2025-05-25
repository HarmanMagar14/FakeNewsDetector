<?php
include '../config.php';

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$where = [];
if ($search) {
    $search = $conn->real_escape_string($search);
    $where[] = "(title LIKE '%$search%' OR user_id IN (SELECT id FROM users WHERE username LIKE '%$search%'))";
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
    exit;
}

$output = "";
while ($row = $result->fetch_assoc()) {
    $username = 'Unknown';
    if (isset($row['user_id']) && $row['user_id']) {
        $user_id = (int)$row['user_id'];
        $userRes = $conn->query("SELECT username FROM users WHERE id = $user_id");
        if ($userRes && $userRes->num_rows) {
            $username = $userRes->fetch_assoc()['username'];
        }
    }

    $title = htmlspecialchars($row['title'], ENT_QUOTES);
    $content = htmlspecialchars($row['content'], ENT_QUOTES);
    $category = htmlspecialchars($row['category'], ENT_QUOTES);
    $date_published = htmlspecialchars($row['date_published'], ENT_QUOTES);
    $status = htmlspecialchars($row['status'], ENT_QUOTES);

    $output .= "
        <tr class='article-row'
            data-id='{$row['id']}'
            data-title=\"{$title}\"
            data-content=\"{$content}\"
            data-category=\"{$category}\"
            data-date_published=\"{$date_published}\"
            data-status=\"{$status}\">
            <td>{$row['id']}</td>
            <td>{$title}</td>
            <td>{$content}</td>
            <td>{$category}</td>
            <td>{$date_published}</td>
            <td>{$status}</td>
            <td>{$username}</td>
            <td>
                <button class='btn btn-success btn-sm approveBtn' data-id='{$row['id']}'>Approve</button>
                <button class='btn btn-danger btn-sm rejectBtn' data-id='{$row['id']}'>Reject</button>
            </td>
        </tr>";
}

echo $output;
?>