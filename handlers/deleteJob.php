<?php
  session_start();
  require_once '../db.php';
  require_once '../error.php';

  if (!isset($_SESSION['company_id'])) {
    header('Location: ../login.php');
    exit;
  }

  $jobId = $_GET['job_id'];

  if (!$jobId) {
    die("No job ID provided.");
  }

  $sql = "SELECT * FROM jobs WHERE job_id = ? AND company_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([
    $jobId,
    $_SESSION['company_id']
  ]);

  $job = $stmt->fetch();

  if (!$job) {
    die("You are not authorized to delete this job.");
  }

  $deleteStmt = $conn->prepare("DELETE FROM jobs WHERE job_id = ?");
  $deleteStmt->execute([$jobId]);

  header('Location: ../companyDashboard.php?message=Job+Deleted');
  exit;
