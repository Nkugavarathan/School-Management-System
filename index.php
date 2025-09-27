<?php
// Landing page - index.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart School Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero {
            height: 70vh;
            background: linear-gradient(to right, #0d6efd, #6c757d);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.2rem;
        }

        .features {
            padding: 60px 0;
        }

        .features .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .features .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .features .card i {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 15px;
        }

        footer {
            background-color: #343a40;
            color: #ccc;
            padding: 40px 0 20px 0;
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .social-icons a {
            margin-right: 15px;
            color: #fff;
            font-size: 1.5rem;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: #0d6efd;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">SSMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome to Smart School Management System</h1>
        <p>Manage attendance, academics, fees, study materials, announcements, and more!</p>
        <a href="login.php" class="btn btn-light btn-lg mt-3">Login Now</a>
    </section>

    <!-- Features Section -->
    <section class="features container text-center">
        <h2 class="mb-5 fw-bold">Our Features</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow p-3">
                    <div class="card-body">
                        <i class="fas fa-users"></i>
                        <h5 class="card-title">User Management</h5>
                        <p class="card-text">Role-based access for Admin, Teacher, Student, and Parent.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow p-3">
                    <div class="card-body">
                        <i class="fas fa-calendar-check"></i>
                        <h5 class="card-title">Attendance Tracking</h5>
                        <p class="card-text">Daily attendance management, manual or QR code based.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow p-3">
                    <div class="card-body">
                        <i class="fas fa-book"></i>
                        <h5 class="card-title">Academic Records</h5>
                        <p class="card-text">Exam marks, grades, and student performance reports.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow p-3">
                    <div class="card-body">
                        <i class="fas fa-money-check-dollar"></i>
                        <h5 class="card-title">Fee Management</h5>
                        <p class="card-text">Track dues, payments, and generate receipts.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow p-3">
                    <div class="card-body">
                        <i class="fas fa-file-upload"></i>
                        <h5 class="card-title">Study Materials</h5>
                        <p class="card-text">Teachers upload, students download study notes.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow p-3">
                    <div class="card-body">
                        <i class="fas fa-bullhorn"></i>
                        <h5 class="card-title">Notice Board</h5>
                        <p class="card-text">Announcements, circulars, and event notifications.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container my-5 text-center">
        <h2 class="mb-4 fw-bold">Contact Us</h2>
        <p>Email: info@ssms.com | Phone: +94 77 123 4567</p>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <div class="row mb-3">
                <div class="col-md-12 social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <p>&copy; <?= date('Y') ?> Smart School Management System. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>