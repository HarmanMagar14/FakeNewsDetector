<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
          <li class="nav-item"><a class="nav-link active" href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="admin_article.php"><i class="bi bi-file-earmark-text me-2"></i>Articles</a></li>
          <li class="nav-item"><a class="nav-link" href="admin_user.php"><i class="bi bi-people me-2"></i>Users</a></li>
          <li class="nav-item"><a class="nav-link" href="admin_log.php"><i class="bi bi-bar-chart-line me-2"></i>Logs</a></li>
          <li class="nav-item"><a class="nav-link" href="../UserAuthentication/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
      </nav>
    
      <main class="col-md-10 ms-sm-auto px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
          <h2 class="h4">Dashboard</h2>
        </div>

        <div class="row g-4 mb-4">
          <div class="col-md-3">
            <div class="card text-white bg-primary">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <h6>Total Articles</h6>
                    <h3>320</h3>
                  </div>
                  <i class="bi bi-journal-richtext card-icon"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-white bg-success">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <h6>True Articles</h6>
                    <h3>180</h3>
                  </div>
                  <i class="bi bi-check-circle card-icon"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-white bg-danger">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <h6>Fake Articles</h6>
                    <h3>100</h3>
                  </div>
                  <i class="bi bi-x-circle card-icon"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-white bg-warning">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <h6>Pending Articles</h6>
                    <h3>40</h3>
                  </div>
                  <i class="bi bi-clock card-icon"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4">
          <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title">Fake vs True Detection Over Time</h5>
                <canvas id="fakeTrueChart"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title">Trending Fake News Keywords</h5>
                <canvas id="keywordChart"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title">Article Count by Status</h5>
                <canvas id="statusChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        
</body>
</html>
