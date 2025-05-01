<?php

include '../db.php';

session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    die("User not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'] ?? null;
    $title = $_POST['title'] ?? null;
    $email = $_POST['email'] ?? null;
    $address = $_POST['address'] ?? null;
    $about = $_POST['about'] ?? null;
    $linkedin = $_POST['linkedin_url'] ?? null;
    $github = $_POST['github_url'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $dob = $_POST['date_of_birth'] ?? null;

    // صورة البروفايل
    $profilePicUrl = null;
    if (!empty($_FILES['profile_picture']['name'])) {
        $fileName = uniqid() . '_' . $_FILES['profile_picture']['name'];
        $uploadPath = "../uploads/" . $fileName;
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath)) {
            die("Error uploading profile picture.");
        }
        $profilePicUrl = substr($uploadPath, 1);
    }

    // السيرة الذاتية
    $resumeUrl = null;
    if (!empty($_FILES['resume']['name'])) {
        $resumeName = uniqid() . '_' . $_FILES['resume']['name'];
        $resumeUploadPath = "../uploads/" . $resumeName;
        if (!move_uploaded_file($_FILES['resume']['tmp_name'], $resumeUploadPath)) {
            die("Error uploading resume.");
        }
        $resumeUrl = substr($resumeUploadPath, 1);
    }

    // بناء SQL
    $sql = "UPDATE users SET full_name = ?, job_title = ?, email = ?, address = ?, about = ?, linkedin_url = ?, github_url = ?, gender = ?, date_of_birth = ?";
    $params = [$fullName, $title, $email, $address, $about, $linkedin, $github, $gender, $dob];

    if ($profilePicUrl !== null) {
        $sql .= ", profile_picture_url = ?";
        $params[] = $profilePicUrl;
    }

    if ($resumeUrl !== null) {
        $sql .= ", resume_url = ?";
        $params[] = $resumeUrl;
    }

    $sql .= " WHERE user_id = ?";
    $params[] = $_SESSION['user_id'];

    // طباعة للتصحيح
    echo '<pre>';
    echo "SQL: $sql\n";
    echo "User ID: " . $_SESSION['user_id'] . "\n";
    print_r($params);
    echo '</pre>';

    try {
        // تحضير الـ statement
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . implode(", ", $conn->errorInfo()));
        } else {
            echo  'conn Done Good';
        }

        // تنفيذ الـ query
        $stmt->execute($params);

        // التحقق من نجاح التحديث
        if ($stmt->rowCount() > 0) {
            echo "Profile updated successfully.";
            header("Location: ../profile.php?status=updated");
            exit;
        } else {
            echo "No changes made or record not found for user_id: " . $_SESSION['user_id'];
        }
    } catch (PDOException $e) {
        die("Error executing query: " . $e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>