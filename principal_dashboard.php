<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
  header('Location: login.html');
  exit();
}
?>
<?php if ($_SESSION['role'] !== 'principal') {
  header('Location: login.html');
  exit();
} ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="style.css">



  <header>
    <div class="logo">
      <img src="images/logo.png" alt="Smart School Logo">
      <h2>SMART SCHOOL</h2>
    </div>
    <nav>
      <a href="home.html">HOME</a>
      <a href="#">FEATURES</a>
      <a href="#">DEMO</a>
      <a href="#">HOW IT WORKS</a>
      <a href="#">HELP</a>
      <a href="#">SUPPORT</a>
    </nav>
  </header>


  <title>Principal Dashboard - SSMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <div class="container-fluid py-4">
    <h3 class="mb-4">WELCOME!</h3>

    <!-- Stats cards -->
    <div class="row g-3">
      <div class="col-md-3">
        <div class="card text-bg-primary p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="small">Total Students</div>
              <div class="fs-4">1,240</div>
            </div>
            <i class="fa-solid fa-user-graduate fa-2x"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-bg-success p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="small">Total Teachers</div>
              <div class="fs-4">85</div>
            </div>
            <i class="fa-solid fa-chalkboard-user fa-2x"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-bg-warning p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="small">Pending Fees</div>
              <div class="fs-4">LKR 45,000</div>
            </div>
            <i class="fa-solid fa-sack-dollar fa-2x"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-bg-danger p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="small">Low Stock</div>
              <div class="fs-4">12</div>
            </div>
            <i class="fa-solid fa-box-open fa-2x"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Graphs -->
    <div class="row g-3 mt-1">
      <div class="col-lg-8">
        <div class="card p-3" style="height: 360px;">
          <h6 class="mb-3"><i class="fa-solid fa-chart-line me-2"></i>Student Performance Overview</h6>
          <canvas id="performanceChart"></canvas>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card p-3" style="height: 360px;">
          <h6 class="mb-3"><i class="fa-solid fa-users-line me-2"></i> Attendance This Week</h6>
          <canvas id="attendanceChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Announcements & Reports -->
    <div class="row g-3 mt-1">
      <div class="col-lg-6">
        <div class="card p-3">
          <h6 class="mb-3"><i class="fa-solid fa-bullhorn me-2"></i> Recent Announcements</h6>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Term exams scheduled for next month.</li>
            <li class="list-group-item">Staff meeting on Friday, 2 PM.</li>
            <li class="list-group-item">New library books arrival.</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card p-3">
          <h6 class="mb-3"><i class="fa-solid fa-clipboard-list me-2"></i> Quick Reports</h6>
          <div class="d-flex flex-wrap gap-2">
            <a href="#" class="btn btn-outline-primary"><i class="fa-solid fa-file-pdf me-2"></i>Attendance PDF</a>
            <a href="#" class="btn btn-outline-success"><i class="fa-solid fa-file-excel me-2"></i>Marks Excel</a>
            <a href="#" class="btn btn-outline-warning"><i class="fa-solid fa-receipt me-2"></i>Fees Summary</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="assets/js/scripts.js"></script>


  <div class="moving-text-container">
    <div class="moving-text">
      📢 Welcome to Smart School Management System! Stay updated with school news, events, and announcements.
    </div>
  </div>
  <footer>
    <div>
      <h4>MEET SMART SCHOOL</h4>
      <a href="home.html">Home</a><br>
      <a href="features.html">Features</a><br>
      <a href="#">Demo</a><br>
      <a href="#">Support</a><br>
      <a href="#">How it works</a><br>
      <a href="#">Help</a><br>
    </div>
    <div>
      <h4>FOLLOW US</h4>
      <div class="social-icons">
        <a href="https://web.facebook.com/facebook/?_rdc=1&_rdr#"><img src="images/fb.png">Facebook</a><br>
        <a href="https://x.com/"><img src="images/twitter.png">Twitter</a><br>
        <a href="https://www.youtube.com/"><img src="images/youtube.png">YouTube</a>
      </div>
    </div>
    <div>
      <h4>CONTACT US</h4>
      <div class="social-icons">
        <img src="images/whatsapp.png" alt="whatsapp">Whatsapp 0743313385<br>
        <img src="images/call.png">Mobile 0743313385<br>
      </div>
    </div>

    <div>
      <h4>TESTIMONIALS</h4>
      <!-- --- Added for moving reviews --- -->
      <div class="review-slider">
        <p>"Great platform! It improved our school operations."</p>
        <p>"Easy to use and saves a lot of time!"</p>
        <p>"Excellent customer support and features."</p>
        <p>"Our teachers love using Smart School!"</p>
      </div>
    </div>

  </footer>

</body>

</html>