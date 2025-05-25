<?php
include '../config.php';
$res = $conn->query("SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 100");
while ($row = $res->fetch_assoc()) {
    echo "<tr>
      <td>{$row['created_at']}</td>
      <td>{$row['username']}</td>
      <td>{$row['usertype']}</td>
      <td>{$row['action']}</td>
      <td>{$row['details']}</td>
    </tr>";
}
?>