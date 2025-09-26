


<?php
session_start();

$servername = "localhost";
$username   = "root";     // default XAMPP user
$password   = "";         // default XAMPP password is empty
$dbname     = "smartschool";
$port       = 3306;       // adjust if your MySQL uses another port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}



// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.html");
    exit();
}


$teacher_id = $_SESSION['user_id'];  // from login session
$message = "";

/* -----------------------------
   1. Record Marks (Insert)
----------------------------- */
if (isset($_POST['save_marks'])) {
    $student_id = $_POST['student_id'];
    $subject    = $_POST['subject'];
    $exam_name  = $_POST['exam_name'];
    $marks      = $_POST['marks'];
    $exam_date  = $_POST['exam_date'];

    $sql = "INSERT INTO marks (student_id, teacher_id, subject, exam_name, marks, exam_date)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissis", $student_id, $teacher_id, $subject, $exam_name, $marks, $exam_date);

    if ($stmt->execute()) {
        $message = "Marks recorded successfully!";
    } else {
        $message = "Error saving marks: " . $conn->error;
    }
}

/* -----------------------------
   2. Take Attendance (Insert)
----------------------------- */
if (isset($_POST['save_attendance'])) {
    $student_id = $_POST['student_id'];
    $status     = $_POST['status'];
    $date       = $_POST['date'];

    $sql = "INSERT INTO attendance (student_id, teacher_id, date, status)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $student_id, $teacher_id, $date, $status);

    if ($stmt->execute()) {
        $message = "Attendance marked!";
    } else {
        $message = "Error saving attendance: " . $conn->error;
    }
}

/* -----------------------------
   3. Upload Study Material
----------------------------- */
if (isset($_POST['upload_material'])) {
    $subject = $_POST['subject'];
    $grade   = $_POST['grade'];
    $title   = $_POST['title'];

    $target_dir = "uploads/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO materials (teacher_id, subject, grade, title, file_path)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isiss", $teacher_id, $subject, $grade, $title, $target_file);
        if ($stmt->execute()) {
            $message = "Study material uploaded!";
        } else {
            $message = "Database error: " . $conn->error;
        }
    } else {
        $message = "File upload failed!";
    }
}

/* -----------------------------
   4. Send Message
----------------------------- */
if (isset($_POST['send_message'])) {
    $receiver_id = $_POST['receiver_id']; // could be student or parent
    $content     = $_POST['content'];

    $sql = "INSERT INTO messages (sender_id, receiver_id, content)
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $teacher_id, $receiver_id, $content);

    if ($stmt->execute()) {
        $message = "Message sent!";
    } else {
        $message = "Error sending message: " . $conn->error;
    }
}

/* -----------------------------
   Fetch Students List
----------------------------- */
$sql_students = "SELECT student_id, name, grade, class_id 
                 FROM students ORDER BY grade, class_id";
$result_students = $conn->query($sql_students);
?>








<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard - SSMS</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  
     <link rel="stylesheet" href="style.css">


</head>
<body class="bg-light">

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
<div class="container mt-4">
  <h3>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> (Teacher)</h3>

  <?php if ($message): ?>
    <div class="alert alert-info"><?= $message ?></div>
  <?php endif; ?>

  <!-- Record Marks -->
  <div class="card mt-3 p-3">
    <h5><i class="fa-solid fa-pen-to-square"></i> Record Marks</h5>
    <form method="post" class="row g-2">
      <div class="col-md-3">
        <label>Student</label>
        <select name="student_id" class="form-select" required>
          <?php while($s = $result_students->fetch_assoc()): ?>
            <option value="<?= $s['student_id'] ?>"><?= $s['name'] ?> (Grade <?= $s['grade'] ?>)</option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-2"><input type="text" name="subject" placeholder="Subject" class="form-control" required></div>
      <div class="col-md-2"><input type="text" name="exam_name" placeholder="Exam" class="form-control" required></div>
      <div class="col-md-2"><input type="number" name="marks" placeholder="Marks" class="form-control" required></div>
      <div class="col-md-2"><input type="date" name="exam_date" class="form-control" required></div>
      <div class="col-md-1 d-grid"><button name="save_marks" class="btn btn-primary">Save</button></div>
    </form>
  </div>

  <!-- Attendance -->
  <div class="card mt-3 p-3">
    <h5><i class="fa-solid fa-list-check"></i> Take Attendance</h5>
    <form method="post" class="row g-2">
      <div class="col-md-4">
        <select name="student_id" class="form-select" required>
          <?php
          $res = $conn->query("SELECT student_id, name FROM students");
          while($stu = $res->fetch_assoc()):
          ?>
          <option value="<?= $stu['student_id'] ?>"><?= $stu['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select">
          <option>Present</option>
          <option>Absent</option>
          <option>Late</option>
        </select>
      </div>
      <div class="col-md-3"><input type="date" name="date" class="form-control" required></div>
      <div class="col-md-2 d-grid"><button name="save_attendance" class="btn btn-success">Mark</button></div>
    </form>
  </div>

  <!-- Upload Materials -->
  <div class="card mt-3 p-3">
    <h5><i class="fa-solid fa-file-arrow-up"></i> Upload Study Material</h5>
    <form method="post" enctype="multipart/form-data" class="row g-2">
      <div class="col-md-3"><input type="text" name="title" placeholder="Title" class="form-control" required></div>
      <div class="col-md-2"><input type="text" name="subject" placeholder="Subject" class="form-control" required></div>
      <div class="col-md-2"><input type="number" name="grade" placeholder="Grade" class="form-control" required></div>
      <div class="col-md-3"><input type="file" name="file" class="form-control" required></div>
      <div class="col-md-2 d-grid"><button name="upload_material" class="btn btn-warning">Upload</button></div>
    </form>
  </div>

  <!-- Messages -->
  <div class="card mt-3 p-3">
    <h5><i class="fa-solid fa-comments"></i> Send Message</h5>
    <form method="post" class="row g-2">
      <div class="col-md-4">
        <select name="receiver_id" class="form-select" required>
          <?php
          $users = $conn->query("SELECT user_id, name, role FROM users WHERE role IN ('student','parent')");
          while($u = $users->fetch_assoc()):
          ?>
          <option value="<?= $u['user_id'] ?>"><?= $u['name'] ?> (<?= $u['role'] ?>)</option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-6"><input type="text" name="content" placeholder="Your message" class="form-control" required></div>
      <div class="col-md-2 d-grid"><button name="send_message" class="btn btn-info">Send</button></div>
    </form>
  </div>
</div>




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
