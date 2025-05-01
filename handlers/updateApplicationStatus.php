<?php
  include '../error.php';
  include '../db.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'];
    $status = $_POST['status'];

    if (!$application_id || !in_array($status, ['Accepted', 'Rejected'])) {
      die('Invalid input');
    }

    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE application_id = ?");
    $stmt->execute([$status, $application_id]);

    if ($status == 'Accepted') {
      // جلب job_id و user_id من جدول applications
      $stmt = $conn->prepare('SELECT job_id, user_id FROM applications WHERE application_id = ?');
      $stmt->execute([$application_id]);
      $application = $stmt->fetch();

      $job_id = $application['job_id'];
      $user_id = $application['user_id'];

      // تحديث حالة الوظيفة لـ Closed
      $stmt = $conn->prepare('UPDATE jobs SET status = "Closed" WHERE job_id = ?');
      $stmt->execute([$job_id]);

      // جلب بيانات الوظيفة
      $stmt = $conn->prepare("SELECT title, description, company_id FROM jobs WHERE job_id = ?");
      $stmt->execute([$job_id]);
      $job = $stmt->fetch();

      // جلب اسم الشركة
      $stmt = $conn->prepare("SELECT company_name FROM companies WHERE company_id = ?");
      $stmt->execute([$job['company_id']]);
      $company = $stmt->fetch();

      // إدخال الـ experience
      $stmt = $conn->prepare("INSERT INTO experiences (user_id, job_title, company_name, start_date, description, is_current)
                              VALUES (?, ?, ?, CURDATE(), ?, 1)");
      $stmt->execute([
        $user_id,
        $job['title'],
        $company['company_name'],
        $job['description']
      ]);
  }


    header("Location: ../companyApplications.php");
    exit;
  }
