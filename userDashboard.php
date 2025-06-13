<?php
session_start();
require_once './db.php';
require_once './error.php';

$userId = $_SESSION['user_id'];

$sql = "
  SELECT 
    a.application_id, a.status, a.applied_at, 
    j.title, j.job_id
  FROM applications AS a
  JOIN jobs AS j ON a.job_id = j.job_id
  WHERE a.user_id = ?
  ORDER BY a.applied_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="style/bootstrap.min.css">
</head>
<body>
  <div class="container py-4">
    <h2>Your Applications</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Job Title</th>
          <th>Status</th>
          <th>Applied At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($applications)): ?>
          <tr>
            <td colspan="4" class="text-center">You haven't applied for any jobs yet.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($applications as $app): ?>
            <tr>
              <td><?= htmlspecialchars($app['title']) ?></td>
              <td><?= htmlspecialchars($app['status']) ?></td>
              <td><?= htmlspecialchars($app['applied_at']) ?></td>
              <td>
                <a href="jobDetails.php?id=<?= $app['job_id'] ?>" class="btn btn-sm btn-info">View Job</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
