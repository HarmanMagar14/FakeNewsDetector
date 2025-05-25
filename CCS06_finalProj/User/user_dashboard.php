<?php 
  include '../config.php';

  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
          <li class="nav-item"><a class="nav-link active" href="user_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>My Account</a></li>
          <li class="nav-item"><a class="nav-link" href="article_view.php"><i class="bi bi-file-earmark-text me-2"></i>Articles</a></li>
          <li class="nav-item"><a class="nav-link" href="../UserAuthentication/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
      </nav>

      <main class="col-md-10 ms-sm-auto px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
        </div>
      
    <?php if ($user): ?>
    <div class="card mb-4" style="max-width: 400px;">
      <div class="card-body">
        <h5 class="card-title mb-3"><i class="bi bi-person-circle me-2"></i>User Profile</h5>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>User Type:</strong> <?php echo htmlspecialchars($user['usertype']); ?></p>
      </div>
    </div>
    <?php endif; ?>
        <hr>
<section id="user-articles" class="mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>My Articles</h4>
    <a href="article_submit.php" class="btn btn-primary">
  <i class="bi bi-plus-circle me-1"></i> Submit New Article
</a>  
  </div>
  <div class="row mb-3">
    <div class="col-md-6">
      <input type="text" id="searchInput" class="form-control" placeholder="Search by title, content, or date...">
    </div>
    <div class="col-md-3">
      <select id="statusFilter" class="form-control">
        <option value="">All Statuses</option>
        <option value="Pending">Pending</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
      </select>
    </div>
  </div>
  <div class="table-responsive">
<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Content</th>
      <th>Category</th>
      <th>Date Published</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody id="articleTable">
  </tbody>
</table>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="script.js"></script>
</body>
</html>
