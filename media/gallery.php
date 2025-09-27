<?php
include("../config.php");

$sql = "SELECT * FROM media ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
$role = $_SESSION['role']; // ✅ check role from session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Media Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container p-5">
    <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

    <h2 class="mb-4 text-center">📸 Media Gallery</h2>
    <div class="row g-3">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6><?php echo $row['title']; ?></h6>
                        <p class="text-muted small"><?php echo $row['description']; ?></p>

                        <!-- Thumbnail -->
                        <?php if ($row['file_type'] == 'image') { ?>
                            <img src="<?php echo $row['file_path']; ?>"
                                class="img-fluid rounded gallery-item"
                                data-bs-toggle="modal"
                                data-bs-target="#mediaModal"
                                data-type="image"
                                data-src="<?php echo $row['file_path']; ?>"
                                style="max-height:180px; cursor:pointer;">
                        <?php } else { ?>
                            <video class="img-fluid rounded gallery-item"
                                data-bs-toggle="modal"
                                data-bs-target="#mediaModal"
                                data-type="video"
                                data-src="<?php echo $row['file_path']; ?>"
                                style="max-height:180px; cursor:pointer;" muted>
                                <source src="<?php echo $row['file_path']; ?>" type="video/mp4">
                            </video>
                        <?php } ?>

                        <!-- ✅ Show delete button only if Admin -->
                        <?php if ($role == 'admin') { ?>
                            <form method="POST" action="delete.php" class="mt-2">
                                <input type="hidden" name="media_id" value="<?php echo $row['media_id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>


    <!-- Bootstrap Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <span class="btn-close float-end" data-bs-dismiss="modal"></span>
                    <div id="modalContent"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle click on gallery item
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', function() {
                let type = this.getAttribute('data-type');
                let src = this.getAttribute('data-src');
                let modalContent = document.getElementById('modalContent');

                if (type === 'image') {
                    modalContent.innerHTML = `<img src="${src}" class="img-fluid rounded">`;
                } else {
                    modalContent.innerHTML = `
                <video controls autoplay style="width:100%; max-height:500px;">
                    <source src="${src}" type="video/mp4">
                    Your browser does not support video.
                </video>`;
                }
            });
        });
    </script>
</body>

</html>