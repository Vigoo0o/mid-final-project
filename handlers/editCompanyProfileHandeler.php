<?php
include '../error.php';
include '../db.php';
session_start();

if (!isset($_SESSION['company_id'])) {
    die("Unauthorized access.");
}

$companyId = $_SESSION['company_id'];

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$industry = $_POST['industry'] ?? '';
$address = $_POST['address'] ?? '';
$website = $_POST['site'] ?? '';
$about = $_POST['about'] ?? '';
$whyChoose = $_POST['why_choies'] ?? '';

$profilePictureUrl = null;

if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['profile_picture']['tmp_name'];
    $fileName = basename($_FILES['profile_picture']['name']);
    $targetDir = "./uploads/";
    $targetPath = $targetDir . uniqid() . "_" . $fileName;

    // تأكد أن مجلد الرفع موجود
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($fileTmp, $targetPath)) {
        $profilePictureUrl = $targetPath;
    }
}

try {
    $query = "UPDATE companies 
              SET company_name = ?, email = ?, description = ?, why_choose = ?, 
                  industry = ?, address = ?, website = ?";

    if ($profilePictureUrl) {
        $query .= ", logo_url = ?";
    }

    $query .= " WHERE company_id = ?";

    $stmt = $conn->prepare($query);

    $params = [$name, $email, $about, $whyChoose, $industry, $address, $website];

    if ($profilePictureUrl) {
        $params[] = $profilePictureUrl;
    }

    $params[] = $companyId;

    $stmt->execute($params);

    // Redirect بعد الحفظ
    header("Location: ../companyProfile.php?update=success");
    exit;

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
