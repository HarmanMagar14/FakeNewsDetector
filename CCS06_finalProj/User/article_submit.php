<?php
include '../config.php';
$categories = [];
$res = $conn->query("SELECT * FROM categories ORDER BY name ASC");
while ($row = $res->fetch_assoc()) {
    $categories[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create or Edit Article</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"><?php echo isset($_GET['id']) ? 'Edit Article' : 'Submit Article'; ?></h1>
        <form action="article_save.php" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($_GET['title']) ? htmlspecialchars($_GET['title']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo isset($_GET['content']) ? htmlspecialchars($_GET['content']) : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="source_url" class="form-label">Source URL</label>
                <input type="url" class="form-control" id="source_url" name="source_url" value="<?php echo isset($_GET['source_url']) ? htmlspecialchars($_GET['source_url']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="date_published" class="form-label">Date Published</label>
                <input type="date" class="form-control" id="date_published" name="date_published" value="<?php echo isset($_GET['date_published']) ? $_GET['date_published'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['name']); ?>"
                            <?php if (isset($_GET['category']) && $_GET['category'] == $cat['name']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"><?php echo isset($_GET['comment']) ? htmlspecialchars($_GET['comment']) : ''; ?></textarea>
                <small class="form-text text-muted">Add an initial comment to your article (optional).</small>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo isset($_GET['id']) ? 'Update Article' : 'Submit Article'; ?></button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>