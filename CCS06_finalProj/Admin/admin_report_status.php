<?php
include '../config.php';

$query = "SELECT status, COUNT(*) as count FROM articles WHERE status IS NOT NULL AND status != '' GROUP BY status";
$res = $conn->query($query);

$data = [];
while ($row = $res->fetch_assoc()) {
    if (!empty($row['status'])) { // Only add non-empty statuses
        $data[$row['status']] = (int)$row['count'];
    }
}
echo json_encode($data);
?>