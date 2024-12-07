<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['student_id'];
    $name = $_POST['student_name'];
    $email = $_POST['student_email'];
    $phone = preg_replace('/[^0-9]/', '', $_POST['student_phone']); // Remove non-numeric characters
    $address = $_POST['student_address'];
    $class = $_POST['student_class'];
    $photo = $_FILES['student_photo']['name'];
    $target = "uploads/" . basename($photo);

    // Check if a new photo is uploaded
    if ($photo) {
        if (move_uploaded_file($_FILES['student_photo']['tmp_name'], $target)) {
            $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=?, address=?, class=?, photo=? WHERE id=?");
            $stmt->bind_param("ssssssi", $name, $email, $phone, $address, $class, $photo, $id);
        } else {
            echo "Failed to upload photo.";
            $conn->close();
            exit();
        }
    } else {
        $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=?, address=?, class=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $class, $id);
    }

    if ($stmt->execute()) {
        header("Location: manage_students.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM students WHERE id=$id");
    $student = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Student</h2>
        <form action="edit_student.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
            <div class="form-group">
                <label for="student_name">Name:</label>
                <input type="text" id="student_name" name="student_name" class="form-control" value="<?php echo $student['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="student_email">Email:</label>
                <input type="email" id="student_email" name="student_email" class="form-control" value="<?php echo $student['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="student_phone">Phone:</label>
                <input type="text" id="student_phone" name="student_phone" class="form-control" value="<?php echo $student['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="student_address">Address:</label>
                <textarea id="student_address" name="student_address" class="form-control" required><?php echo $student['address']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="student_class">Class:</label>
                <input type="text" id="student_class" name="student_class" class="form-control" value="<?php echo $student['class']; ?>" required>
            </div>
            <div class="form-group">
                <label for="student_photo">Photo:</label>
                <input type="file" id="student_photo" name="student_photo" class="form-control-file">
                <img src="uploads/<?php echo $student['photo']; ?>" alt="Student Photo" width="100" height="100">
            </div>
            <button type="submit" class="btn btn-warning">Update Student</button>
            <button type="button" class="btn btn-primary text-right"><a href="manage_students.php" style="color:aliceblue;">Back</a></button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
