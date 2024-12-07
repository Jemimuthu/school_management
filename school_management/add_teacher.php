<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['teacher_name'];
    $email = $_POST['teacher_email'];
    $phone = preg_replace('/[^0-9]/', '', $_POST['teacher_phone']); // Remove non-numeric characters
    $address = $_POST['teacher_address'];
    $subject = $_POST['teacher_subject'];
    $photo = $_FILES['teacher_photo']['name'];
    $target = "uploads/" . basename($photo);

    // Move the uploaded photo to the uploads directory
    if (move_uploaded_file($_FILES['teacher_photo']['tmp_name'], $target)) {
        // Insert teacher details into the database
        $stmt = $conn->prepare("INSERT INTO teachers (name, email, phone, address, subject, photo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone, $address, $subject, $photo);

        if ($stmt->execute()) {
            header("Location: manage_teachers.php");
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
