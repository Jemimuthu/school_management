<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

include('db.php');

// Fetch teachers for displaying in a table
$result = $conn->query("SELECT * FROM teachers");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Teachers</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_teachers.php">Manage Teachers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Manage Teachers</h2>

        <!-- Add Teacher Button -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTeacherModal">
            Add Teacher
        </button>

        <!-- Teachers Table -->
        <h3 class="mt-5">Teachers List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Subject</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['subject']; ?></td>
                        <td><img src="uploads/<?php echo $row['photo']; ?>" alt="Teacher Photo" width="50" height="50"></td>
                        <td>
                            <a href="edit_teacher.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_teacher.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add Teacher Modal -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeacherModalLabel">Add Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_teacher.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="teacher_name">Name:</label>
                            <input type="text" id="teacher_name" name="teacher_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="teacher_email">Email:</label>
                            <input type="email" id="teacher_email" name="teacher_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="teacher_phone">Phone:</label>
                            <input type="text" id="teacher_phone" name="teacher_phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="teacher_address">Address:</label>
                            <textarea id="teacher_address" name="teacher_address" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="teacher_subject">Subject:</label>
                            <input type="text" id="teacher_subject" name="teacher_subject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="teacher_photo">Photo:</label>
                            <input type="file" id="teacher_photo" name="teacher_photo" class="form-control-file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Teacher</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
