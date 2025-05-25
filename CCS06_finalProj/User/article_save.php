<?php
session_start();
include "../config.php";

$id = $_POST['id'] ?? '';
$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';
$source_url = $_POST['source_url'] ?? '';
$date_published = $_POST['date_published'] ?? date('Y-m-d');
$category = $_POST['category'] ?? '';
$status = $_POST['status'] ?? 'Pending';
$comment = $_POST['comment'] ?? '';

// --- Fetch fake keywords from DB ---
$fake_keywords = [];
$res = $conn->query("SELECT keyword FROM fake_keywords");
while ($row = $res->fetch_assoc()) {
    $fake_keywords[] = strtolower($row['keyword']);
}

// --- Fake News Detection ---
$found = 0;
$content_lower = strtolower($content);
foreach ($fake_keywords as $word) {
    if (strpos($content_lower, $word) !== false) {
        $found++;
    }
}
$detection_result = ($found > 0) ? 'Fake' : 'True';

if ($id) {
    $query = "UPDATE articles 
              SET title='$title', content='$content', source_url='$source_url', date_published='$date_published', category='$category', status='$status', comment='$comment', detection_result='$detection_result'   
              WHERE id=$id";
    if ($conn->query($query)) {
        log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'user', $_SESSION['usertype'] ?? 'user', 'Update Article', "Article ID: $id");
        header("Location: user_dashboard.php");
        exit();
    }
} else {
    $query = "INSERT INTO articles (title, content, source_url, date_published, category, status, comment, detection_result) 
              VALUES ('$title', '$content', '$source_url', '$date_published', '$category', '$status', '$comment', '$detection_result')";
    if ($conn->query($query)) {
        $new_article_id = $conn->insert_id;
        log_activity($conn, $_SESSION['user_id'] ?? 0, $_SESSION['username'] ?? 'user', $_SESSION['usertype'] ?? 'user', 'Create Article', "Article ID: $new_article_id");
        header("Location: user_dashboard.php");
        exit();
    }
}

echo "Error: " . $conn->error;
?>