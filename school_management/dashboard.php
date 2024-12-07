<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">School Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($_SESSION['role'] == 'admin') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.html">Add User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit_user.html">Edit User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="delete_user.html">Delete User</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Welcome to the School Management System</h1>
        <p>Role: <?php echo $_SESSION['role']; ?></p>
        
        <?php if ($_SESSION['role'] == 'admin') { ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Admin Panel</h5>
                    <p class="card-text">Manage students and teachers, view reports, and more.</p>
                    <a href="manage_students.php" class="btn btn-primary">Manage Students</a>
                    <a href="manage_teachers.php" class="btn btn-primary">Manage Teachers</a>
                </div>
            </div>
        <?php } elseif ($_SESSION['role'] == 'teacher') { ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Teacher Panel</h5>
                    <p class="card-text">View and manage your courses and student grades.</p>
                    <a href="view_courses.php" class="btn btn-primary">View Courses</a>
                    <a href="view_grades.php" class="btn btn-primary">View Grades</a>
                </div>
            </div>
        <?php } elseif ($_SESSION['role'] == 'student') { ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Student Panel</h5>
                    <p class="card-text">View your grades and course schedules.</p>
                    <a href="view_grades.php" class="btn btn-primary">View Grades</a>
                    <a href="view_schedule.php" class="btn btn-primary">View Schedule</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcnd.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
