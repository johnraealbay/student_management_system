<?php
include "pages/config/coursedb.php";

$countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses");
$row = mysqli_fetch_assoc($countResult);
$totalCourses = $row['total'];
?>

<?php
include "pages/config/studentsdb.php";

$countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM student");
$row = mysqli_fetch_assoc($countResult);
$totalStudents = $row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<h4>Dashboard</h4>
<p class="text-muted">Admin: <?php echo $_SESSION['username']; ?></p>

<div class="row g-4 mt-2">
    <div class="col-md-4">
        <div class="card text-white bg-primary shadow">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h3><?= $totalCourses ?></h3>
                    <p>Listed Courses</p>
                    <a href="?page=course" class="text-white text-decoration-none">View Details</a>
                </div>
                <i class="bi bi-file-earmark card-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-success shadow">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h3>9</h3>
                    <p>Subjects/Majors</p>
                    <a href="?page=subject" class="text-white text-decoration-none">View Details</a>
                </div>
                <i class="bi bi-journals card-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-warning shadow">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h3><?= $totalStudents ?></h3>
                    <p>Total Students</p>
                    <a href="?page=students" class="text-white text-decoration-none">View Details</a>
                </div>
                <i class="bi bi-people card-icon"></i>
            </div>
        </div>
    </div>
</div>

</body>
</html>