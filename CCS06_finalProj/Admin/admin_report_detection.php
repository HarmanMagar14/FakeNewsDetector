<?php
include '../config.php';

$query = "SELECT DATE(date_published) as date, detection_result, COUNT(*) as count
          FROM articles
          WHERE detection_result IN ('Fake', 'True')
          GROUP BY DATE(date_published), detection_result
          ORDER BY DATE(date_published) ASC";
$res = $conn->query($query);

$data = [];
while ($row = $res->fetch_assoc()) {
    $date = $row['date'];
    $result = $row['detection_result'];
    $count = (int)$row['count'];
    if (!isset($data[$date])) $data[$date] = ['Fake' => 0, 'True' => 0];
    $data[$date][$result] = $count;
}
echo json_encode($data);
?>