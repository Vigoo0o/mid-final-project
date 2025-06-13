<?php
  session_start();
  require_once '../db.php';
  require_once '../error.php';

  if (!isset($_SESSION['company_id'])) {
    header('Location: ../login.php');
    exit;
  }

  $jobId = $_GET['job_id'] ?? null;

  if (!$jobId) {
    die("No job ID provided.");
  }

  // Valid Company
  $sql = "SELECT * FROM jobs WHERE job_id = :jobId AND company_id = :companyId";
  $stmt = $conn->prepare($sql);
  $stmt->execute([
    ':jobId' => $jobId,
    ':companyId' => $_SESSION['company_id']
  ]);

  $job = $stmt->fetch();

  if (!$job) {
    die("Unauthorized.");
  }

  // Status Update
  $update = $conn->prepare("UPDATE jobs SET status = 'Closed' WHERE job_id = :jobId");
  $update->execute([':jobId' => $jobId]);

  header('Location: ../companyDashboard.php?message=Job+Marked+as+Closed');
  exit;
