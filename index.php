<?php
// index.php - Smart School Management System
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart School Management System</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            scroll-behavior: smooth;
            background-color: #98c5ecff;
            color: #212529;
        }

        .hero {
            height: 100vh;
            background: linear-gradient(to right, rgba(13, 110, 253, 0.7), rgba(11, 30, 63, 0.7)),
                url('assets/school-bg.jpg') center center / cover no-repeat;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 0 20px;
            position: relative;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.3rem;
            max-width: 600px;
        }

        /* 
        .features {
            padding: 80px 0;
            background-color: #e3f2fd;
            width: 100%;

        } */

        .features .card {
            background-color: #cfe2ff;
            border: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .features .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            background-color: #f0f8ff;
        }

        .features .card i {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 15px;
        }

        #contact {
            background-color: #cfe2ff;
            border-radius: 5px;
            padding: 60px 0;
            color: #212529;
            width: 50%;
        }

        footer {
            background-color: #0b1e3f;
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
            color: #5bc0ff;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color:#0b1e3f;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">SSMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" data-aos="fade-in" data-aos-offset="0">
        <h1 data-aos="fade-down" data-aos-offset="0">Welcome to Smart School Management System</h1>
        <p data-aos="fade-up" data-aos-offset="0">Manage attendance, academics, fees, study materials, announcements, and more!</p>
        <a href="login.php" class="btn btn-lg mt-3" style="background-color:#5bc0ff; color:#fff; border:none;" data-aos="zoom-in" data-aos-offset="0">Login Now</a>
    </section>

    <!-- Features Section -->
    <section class="features container text-center">
        <h2 class="mb-5 fw-bold" data-aos="fade-up">Our Features</h2>
        <div class="row g-4">
            <?php
            $features = [
                ["icon" => "fa-users", "title" => "User Management", "desc" => "Role-based access for Admin, Teacher, Student, and Parent."],
                ["icon" => "fa-calendar-check", "title" => "Attendance Tracking", "desc" => "Daily attendance management, manual or QR code based."],
                ["icon" => "fa-book", "title" => "Academic Records", "desc" => "Exam marks, grades, and student performance reports."],
                ["icon" => "fa-money-check-dollar", "title" => "Fee Management", "desc" => "Track dues, payments, and generate receipts."],
                ["icon" => "fa-file-upload", "title" => "Study Materials", "desc" => "Teachers upload, students download study notes."],
                ["icon" => "fa-bullhorn", "title" => "Notice Board", "desc" => "Announcements, circulars, and event notifications."]
            ];
            $delay = 0;
            foreach ($features as $feature) {
                echo '<div class="col-md-4" data-aos="fade-up" data-aos-delay="' . $delay . '">
                        <div class="card h-100 shadow p-3">
                            <div class="card-body">
                                <i class="fas ' . $feature["icon"] . '"></i>
                                <h5 class="card-title">' . $feature["title"] . '</h5>
                                <p class="card-text">' . $feature["desc"] . '</p>
                            </div>
                        </div>
                    </div>';
                $delay += 100;
            }
            ?>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container my-5 text-center" data-aos="fade-up">
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

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: false,
            mirror: true
        });
    </script>
</body>

</html>