<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="css/styles.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <!--- Side bar --->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-3">
                <h6 class="text-center text-white">Student Management System</h6>
                <hr class="border border-white opacity-50">

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="index.php?page=dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=course"><i class="bi bi-book"></i> Courses</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=subject"><i class="bi bi-journal"></i> Subjects/Majors</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=students"><i class="bi bi-people"></i> View Students</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=admin"><i class="bi bi-person-circle"></i> Admin Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </div>


            <!--- Main Content --->
            <div class="col-md-10 p-4 main-content">
                <?php
                $page = $_GET['page'] ?? 'dashboard';

                $pages = ['dashboard', 'course', 'subject', 'students', 'admin'];

                if (in_array($page, $pages)) {
                    include "pages/$page.php";
                } else {
                    echo "<h4>Page not found</h4>";
                }
                ?>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>