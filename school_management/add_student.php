<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['student_name'];
    $email = $_POST['student_email'];
    $phone = preg_replace('/[^0-9]/', '', $_POST['student_phone']); // Remove non-numeric characters
    $address = $_POST['student_address'];
    $class = $_POST['student_class'];
    $photo = $_FILES['student_photo']['name'];
    $target = "uploads/" . basename($photo);

    // Move the uploaded photo to the uploads directory
    if (move_uploaded_file($_FILES['student_photo']['tmp_name'], $target)) {
        // Insert student details into the database
        $stmt = $conn->prepare("INSERT INTO students (name, email, phone, address, class, photo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone, $address, $class, $photo);

        if ($stmt->execute()) {
            header("Location: manage_students.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to upload photo.";
    }

    $conn->close();
}
?>
