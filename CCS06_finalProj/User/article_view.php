<?php
include '../config.php';

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'], $_POST['article_id'])) {
    $article_id = (int)$_POST['article_id'];
    $user = $_SESSION['username'] ?? 'Anonymous';
    $comment = $conn->real_escape_string($_POST['comment']);
    $conn->query("INSERT INTO article_comments (article_id, username, comment) VALUES ($article_id, '$user', '$comment')");
}

// Fetch all articles
$articles = [];
$res = $conn->query("SELECT * FROM articles WHERE status = 'Approved' ORDER BY date_published DESC, id DESC");
while ($row = $res->fetch_assoc()) {
    $articles[] = $row;
}

// Fetch all comments for all articles
$comments_by_article = [];
$res = $conn->query("SELECT * FROM article_comments ORDER BY created_at ASC");
while ($row = $res->fetch_assoc()) {
    $comments_by_article[$row['article_id']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
      body { background-color: #f8f9fd; }
      .sidebar {
        height: 100vh;
        background-color: #e8e4de;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        overflow-y: auto;
      }
      .sidebar .nav-link { color: black; }
      .sidebar .nav-link.active { background-color:rgb(169, 173, 182); }
      .main-content {
        margin-left: 250px;
        padding: 40px 20px 20px 20px;
        min-height: 100vh;
        background-color: #f8f9fd;
      }
      @media (max-width: 991px) {
        .sidebar { position: static; width: 100%; height: auto; }
        .main-content { margin-left: 0; padding: 20px; }
      }
      .article-card { margin-bottom: 2rem; }
    </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block sidebar p-3">
        <h4 class="text-white mb-4 d-flex align-items-center">
          <img src="assets/loginBackground.png" alt="Logo" width="250" class="me-2">
        </h4>
        <ul class="nav flex-column">
          <li class="nav-item"><a class="nav-link" href="user_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>My Account</a></li>
          <li class="nav-item"><a class="nav-link active" href="article_view.php"><i class="bi bi-file-earmark-text me-2"></i>Articles</a></li>
          <li class="nav-item"><a class="nav-link" href="../UserAuthentication/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
      </nav>
      <div class="main-content col-md-10">
        <h2>All Articles</h2>
        <?php foreach ($articles as $article): ?>
          <div class="card article-card">
            <div class="card-body">
              <h4 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h4>
              <p><strong>Category:</strong> <?php echo htmlspecialchars($article['category']); ?></p>
              <p><strong>Date Published:</strong> <?php echo htmlspecialchars($article['date_published']); ?></p>
              <p><strong>Status:</strong> <?php echo htmlspecialchars($article['status']); ?></p>
              <hr>
              <div><?php echo nl2br(htmlspecialchars($article['content'])); ?></div>
              <hr>
              <h5>Comments</h5>
              <form method="POST" class="mb-3">
                <input type="hidden" name="article_id" value="<?php echo $article['id']; ?>">
                <textarea name="comment" class="form-control" rows="2" required placeholder="Add a comment..."></textarea>
                <button type="submit" class="btn btn-primary btn-sm mt-2">Post Comment</button>
              </form>
              <?php
                $comments = $comments_by_article[$article['id']] ?? [];
                foreach ($comments as $c):
              ?>
                <div class="mb-2 p-2 border rounded">
                  <strong><?php echo htmlspecialchars($c['username']); ?>:</strong>
                  <span><?php echo nl2br(htmlspecialchars($c['comment'])); ?></span>
                  <div class="text-muted small"><?php echo $c['created_at']; ?></div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
        <a href="user_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
      </div>
    </div>
  </div>
</body>
</html>