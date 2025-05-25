<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Articles & Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
  <style>
    body {
      background-color: #f8f9fd;
    }
    .sidebar {
      height: 100vh;
      background-color: #e8e4de;
      color: white;
      position: fixed;
    }
    .sidebar .nav-link {
      color: black;
    }
    .sidebar .nav-link.active {
      background-color:rgb(169, 173, 182);
    }
    .card {
      border: none;
      border-radius: 1rem;
    }
    .card-icon {
      font-size: 2rem;
    }
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
          <li class="nav-item"><a class="nav-link" href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
          <li class="nav-item"><a class="nav-link active" href="admin_article.php"><i class="bi bi-file-earmark-text me-2"></i>Articles</a></li>
          <li class="nav-item"><a class="nav-link" href="admin_user.php"><i class="bi bi-people me-2"></i>Users</a></li>
          <li class="nav-item"><a class="nav-link" href="admin_log.php"><i class="bi bi-bar-chart-line me-2"></i>Logs</a></li>
         <li class="nav-item"><a class="nav-link" href="../UserAuthentication/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
      </nav>
      <main class="col-md-10 ms-auto px-4">
        <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
          <h2>All Articles</h2>
        </div>
        <a href="export_articles.php" class="btn btn-outline-success mb-2">
  <i class="bi bi-download"></i> Export Articles CSV
</a>
<a href="export_users.php" class="btn btn-outline-success mb-2">
  <i class="bi bi-download"></i> Export Users CSV
</a>
<div class="row mb-3">
  <div class="col-md-6">
    <input type="text" id="adminSearchInput" class="form-control" placeholder="Search by title or user...">
  </div>
  <div class="col-md-3">
    <select id="adminStatusFilter" class="form-control">
      <option value="">All Statuses</option>
      <option value="Pending">Pending</option>
      <option value="Approved">Approved</option>
      <option value="Rejected">Rejected</option>
      <option value="Fake">Fake</option>
    </select>
  </div>
</div>
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">Manage Categories</h5>
      <form id="addCategoryForm" class="mb-3 d-flex">
        <input type="text" class="form-control me-2" name="name" placeholder="New category..." required>
        <button class="btn btn-primary" type="submit">Add</button>
      </form>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="categoryTable">
          <!-- Categories will be loaded here by script.js -->
        </tbody>
      </table>
    </div>
  </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 180px;">Title</th>
                <th style="width: 300px;">Content</th>
                <th style="width: 120px;">Category</th>
                <th style="width: 130px;">Date Published</th>
                <th style="width: 100px;">Status</th>
                <th style="width: 120px;">User</th>
                <th style="width: 120px;">Actions</th>
              </tr>
            </thead>
            <tbody id="adminArticleTable">
              <!-- Articles will be loaded here by script.js -->
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

  <!-- Article Details Modal -->
  <div class="modal fade" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="articleModalLabel">Article Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row">
          <div class="col-md-8">
            <dl class="row">
              <dt class="col-sm-4">ID</dt>
              <dd class="col-sm-8" id="modal-id"></dd>
              <dt class="col-sm-4">Title</dt>
              <dd class="col-sm-8" id="modal-title"></dd>
              <dt class="col-sm-4">Content</dt>
              <dd class="col-sm-8" id="modal-content"></dd>
              <dt class="col-sm-4">Category</dt>
              <dd class="col-sm-8" id="modal-category"></dd>
              <dt class="col-sm-4">Date Published</dt>
              <dd class="col-sm-8" id="modal-date"></dd>
              <dt class="col-sm-4">Status</dt>
              <dd class="col-sm-8" id="modal-status"></dd>
            </dl>
          </div>
          <div class="col-md-4 text-center">
            <h5>Detection Result</h5>
            <div id="detectionResult" class="display-6"></div>
            <div id="detectionPercent" class="mb-3"></div>
            <button class="btn btn-success" id="approveBtn">Approve</button>
            <button class="btn btn-danger" id="rejectBtn">Reject</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>