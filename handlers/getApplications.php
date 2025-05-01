<?php
// companyDashboard.php
// session_start();
// require_once '../db.php';
// require_once '../error.php';

// // تأكد من تسجيل الشركة
// if (!isset($_SESSION['company_id'])) {
//   header('Location: login.php');
//   exit;
// }

// $companyId = $_SESSION['company_id'];
// // Get All Jobs The Company Posted It
// $sql = "
//   SELECT
//     j.job_id,
//     j.title,
//     j.location,
//     j.employment_type,
//     j.status,
//     j.posted_at,
//     COUNT(a.application_id) AS application_count
//   FROM jobs AS j
//   LEFT JOIN applications AS a
//     ON j.job_id = a.job_id
//   WHERE j.company_id = :companyId
//   GROUP BY j.job_id
//   ORDER BY j.posted_at DESC
// ";

// $stmt = $conn->prepare($sql);
// $stmt->execute([':companyId' => $companyId]);
// $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// print_r($jobs);
// echo '</pre>';