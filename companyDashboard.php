<?php
  session_start();
  require_once './db.php';
  require_once './error.php';

  if (isset($_GET['message']) && $_GET['message'] == 'Job Deleted') {
    echo '<div id="popup" style="background: #0ea89b; color: white; padding: 15px; text-align: center;">
    Job Deleted Succsesfuly.
    </div>';
  } else if (isset($_GET['message']) && $_GET['message'] ==  'Job Marked as Closed') {
    echo '<div id="popup" style="background: #0ea89b; color: white; padding: 15px; text-align: center;">
    Job Marked As Done Succsesfuly.
    </div>';
  }

  if (!isset($_SESSION['company_id'])) {
    header('Location: login.php');
    exit;
  }

  $companyId = $_SESSION['company_id'];
  // Get All Jobs The Company Posted It
  $sql = "
    SELECT
      j.job_id,
      j.title,
      j.location,
      j.employment_type,
      j.status,
      j.posted_at,
      COUNT(a.application_id) AS application_count
    FROM jobs AS j
    LEFT JOIN applications AS a
      ON j.job_id = a.job_id
    WHERE j.company_id = :companyId
    GROUP BY j.job_id
    ORDER BY j.posted_at DESC
  ";

  $stmt = $conn->prepare($sql);
  $stmt->execute([':companyId' => $companyId]);
  $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Jobs & Applications</title>
  <link rel="stylesheet" href="style/bootstrap.min.css">
</head>
<body>
  <div class="container py-4">
    <h2>Dashboard</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Job Title</th>
          <th>Location</th>
          <th>Type</th>
          <th>Status</th>
          <th>Posted At</th>
          <th># Applicants</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($jobs)): ?>
          <tr>
            <td colspan="7" class="text-center">No jobs posted yet.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($jobs as $job): ?>
            <tr>
              <td><?= htmlspecialchars($job['title']) ?></td>
              <td><?= htmlspecialchars($job['location']) ?></td>
              <td><?= htmlspecialchars($job['employment_type']) ?></td>
              <td><?= htmlspecialchars($job['status']) ?></td>
              <td><?= htmlspecialchars($job['posted_at']) ?></td>
              <td><?= $job['application_count'] ?></td>
              <td>
                <a href="companyApplications.php?job_id=<?= $job['job_id'] ?>"
                   class="btn btn-sm btn-primary">
                  View Applicants
                </a>
                  <a href="handlers/deleteJob.php?job_id=<?= $job['job_id'] ?>" class="btn btn-danger btn-sm" 
                  onclick="return confirm('Are you sure you want to delete this job?');">
                  Delete
                </a>
                <a href="handlers/closeJob.php?job_id=<?= $job['job_id'] ?>" class="btn btn-warning btn-sm"
                    onclick="return confirm('Mark this job as completed?');">
                    Mark as Done
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
