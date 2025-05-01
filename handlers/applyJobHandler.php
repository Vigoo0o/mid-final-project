<?php
  require_once '../db.php';
  require_once '../error.php';
  session_start();


  if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
  }

  $user_id = $_SESSION['user_id'];
  $job_id = $_POST['job_id'];
  $cover_letter = $_POST['cover_letter'];


  // تأكد إن المستخدم مش مقدم قبل كده
  $stmt = $conn->prepare("SELECT * FROM applications WHERE user_id = ? AND job_id = ?");
  $stmt->execute([$user_id, $job_id]);
  $exists = $stmt->fetch();

  if ($exists) {
    header("Location: ../jobDetails.php?id=$job_id&already_applied=1");
    exit;
  }

  // إدخال الطلب الجديد
  $stmt = $conn->prepare("INSERT INTO applications (user_id, job_id, status, applied_at, cover_letter) VALUES (?, ?, 'Pending', NOW(), ?)");
  $stmt->execute([$user_id, $job_id, $cover_letter]);

  header("Location: ../jobDetails.php?id=$job_id&applied=1");
  exit;
