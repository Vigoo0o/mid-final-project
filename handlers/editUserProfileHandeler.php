<?php

include '../db.php';

session_start();

// Login Check 
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

    // Handel Skills
    $skillsInput = $_POST['skills'] ?? '';
    $skillsArray = array_filter(array_map('trim', explode(',', $skillsInput)));

    // Profile Pic
    $profilePicUrl = null;
    if (!empty($_FILES['profile_picture']['name'])) {
        $fileName = uniqid() . '_' . $_FILES['profile_picture']['name'];
        $uploadPath = "../uploads/" . $fileName;
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath)) {
            die("Error uploading profile picture.");
        }
        $profilePicUrl = substr($uploadPath, 1);
    }

    // CV
    $resumeUrl = null;
    if (!empty($_FILES['resume']['name'])) {
        $resumeName = uniqid() . '_' . $_FILES['resume']['name'];
        $resumeUploadPath = "../uploads/" . $resumeName;
        if (!move_uploaded_file($_FILES['resume']['tmp_name'], $resumeUploadPath)) {
            die("Error uploading resume.");
        }
        $resumeUrl = substr($resumeUploadPath, 1);
    }

    // Update User Date
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

    try {
        // Upgrade
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . implode(", ", $conn->errorInfo()));
        }
        $stmt->execute($params);

        //  Update Skills
        $deleteStmt = $conn->prepare("DELETE FROM user_skills WHERE user_id = ?");
        $deleteStmt->execute([$_SESSION['user_id']]);

        foreach ($skillsArray as $skillName) {
            $selectSkill = $conn->prepare("SELECT id FROM skills WHERE name = ?");
            $selectSkill->execute([$skillName]);
            $skill = $selectSkill->fetch(PDO::FETCH_ASSOC);

            if ($skill) {
                $skillId = $skill['id'];
            } else {
                $insertSkill = $conn->prepare("INSERT INTO skills (name) VALUES (?)");
                $insertSkill->execute([$skillName]);
                $skillId = $conn->lastInsertId();
            }

            $insertUserSkill = $conn->prepare("INSERT INTO user_skills (user_id, skill_id) VALUES (?, ?)");
            $insertUserSkill->execute([$_SESSION['user_id'], $skillId]);
        }

        // Done
        header("Location: ../profile.php?status=updated");
        exit;

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>
