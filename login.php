<?php
session_start();
// Database connection
$conn = new mysqli("localhost", "root", "", "smartschool", 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit();
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$id_number = isset($_POST['id_number']) ? strtolower(trim($_POST['id_number'])) : ''; // lowercase for comparison
$role = isset($_POST['role']) ? trim($_POST['role']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate required fields
if ($email === '' || $id_number === '' || $password === '' || $role === '') {
    echo "<script>alert('All fields are required'); window.location.href='login.html';</script>";
    exit();
}

// Role → ID prefix mapping
$role_prefixes = [
    'principal'     => 'pl',
    'teacher'       => 'tec',
    'parent'        => 'pr',
    'student'       => 'stu',
    'office staff'  => 'os'
];

// Check if prefix matches role
$expected_prefix = $role_prefixes[$role];
if (strpos($id_number, $expected_prefix) !== 0) {
    echo "<script>alert('Identification number does not match the selected role'); window.location.href='login.html';</script>";
    exit();
}

// Prepare query
$stmt = $conn->prepare("SELECT user_id, name, email, identification_number, password, role 
                        FROM users 
                        WHERE email = ? AND identification_number = ? AND role = ? 
                        LIMIT 1");
$stmt->bind_param("sss", $email, $id_number, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['id_number'] = $user['identification_number'];

        // Redirect based on role
        switch ($user['role']) {
            case 'principal':
                header("Location: principal_dashboard.php");
                break;
            case 'office_staff':
                header("Location: officestaff_dashboard.php");
                break;
            case 'teacher':
                header("Location: teacher_dashboard.php");
                break;
            case 'student':
                header("Location: student_dashboard.php");
                break;
            case 'parent':
                header("Location: parent_dashboard.php");
                break;
            default:
                echo "Unknown role.";
                exit();
        }
        exit();
    } else {
        echo "<script>alert('Invalid password'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('Account not found. Check your Email, ID, or Role.'); window.location.href='login.html';</script>";
}
?>
<!-- 
<?php
// db connection
$host = "localhost";
$user = "root"; // change if different
$pass = "";
$dbname = "smartschool";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SSMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #5DADE2, #AF7AC5);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-custom {
            background-color: #58D68D;
            border: none;
            color: white;
        }

        .btn-custom:hover {
            background-color: #45B77D;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4">
                    <h3 class="text-center text-dark">SSMS Login</h3>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger py-2"><?= $error; ?></div>
                        <?php } ?>
                        <button type="submit" class="btn btn-custom w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html> -->