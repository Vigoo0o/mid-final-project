<?php
session_start();
require_once './db.php';
require_once './error.php';

  $referer = $_SERVER['HTTP_REFERER'] ?? '';
  $jobId = $_GET['job_id'] ?? null;

  if (strpos($referer, 'updateApplicationStatus.php') !== false) {
    if (!$jobId) {
      die('Job ID is required.');
    }
  }

$sql = "
  SELECT
    a.application_id, a.status, a.applied_at, a.cover_letter,
    u.user_id, u.full_name, u.email, u.profile_picture_url
  FROM applications AS a
  JOIN users AS u ON a.user_id = u.user_id
  WHERE a.job_id = :jobId
  ORDER BY a.applied_at DESC
";
$stmt = $conn->prepare($sql);
$stmt->execute([':jobId' => $jobId]);
$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Applicants for Job</title>
  <link rel="stylesheet" href="style/bootstrap.min.css">
  <link rel="stylesheet" href="style/main.css">
</head>
<body>
  <div class="container py-4">
    <h2>Applicants for Job</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Email</th>
          <th>Profile Picture</th>
          <th>Cover Letter</th>
          <th>Status</th>
          <th>Applied At</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($applicants)): ?>
          <tr>
            <td colspan="6" class="text-center">No applicants yet.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($applicants as $applicant): ?>
            <tr>
              <td>
                <a href="profile.php?user_id=<?= $applicant['user_id'] ?>">
                  <?= htmlspecialchars($applicant['full_name']) ?>
                </a>
              </td>

              <td><?= htmlspecialchars($applicant['email']) ?></td>
              <td>
                <?php if ($applicant['profile_picture_url']): ?>
                  <img src="<?= htmlspecialchars($applicant['profile_picture_url']) ?>" alt="Profile Picture" width="50">
                <?php else: ?>
                  No image
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($applicant['cover_letter']) ?></td>
              <td><?= htmlspecialchars($applicant['status']) ?></td>
              <td><?= htmlspecialchars($applicant['applied_at']) ?></td>
              <td>
                <td>
                  <?php if ($applicant['status'] === 'Pending'): ?>
                    <form method="POST" action="./handlers/updateApplicationStatus.php" style="display:inline;">
                      <input type="hidden" name="application_id" value="<?= $applicant['application_id'] ?>">
                      <input type="hidden" name="status" value="Accepted">
                      <button class="btn btn-success btn-sm" type="submit">Accept</button>
                    </form>
                    <form method="POST" action="./handlers/updateApplicationStatus.php" style="display:inline;">
                      <input type="hidden" name="application_id" value="<?= $applicant['application_id'] ?>">
                      <input type="hidden" name="status" value="Rejected">
                      <button class="btn btn-danger btn-sm" type="submit">Reject</button>
                    </form>
                  <?php else: ?>
                    <span class="badge bg-secondary">Finalized</span>
                  <?php endif; ?>
                </td>

              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
