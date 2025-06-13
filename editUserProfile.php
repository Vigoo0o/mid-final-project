<?php
  include './error.php';
  include 'auth.php';
  include './components.php';
  include './userData.php';
  
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
  $stmt->execute([$user_id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Profile</title>
  <link rel="stylesheet" href="./style/all.css" />
  <link rel="stylesheet" href="./style/all.min.css" />
  <link rel="stylesheet" href="./style/bootstrap.min.css" />
  <link rel="stylesheet" href="./style/postNewJob.css" />
  <link rel="stylesheet" href="./style/main.css" />
</head>
<body>
  <div class="page">
    <div class="container">
      <div class="head d-flex align-items-center justify-content-between">
        <h2>Edit Profile</h2>
      </div>
      <div class="content d-flex justify-content-between">
        <div class="content">
          <form action="./handlers/editUserProfileHandeler.php" method="POST" enctype="multipart/form-data">
            <!-- GENERAL INFORMATION -->
            <section class="userInfoGeneral">
              <h3>General</h3>

              <!-- Profile Picture -->
              <div class="avatar form-group">
                <label>Profile Picture</label><br>
                <?php
                  $profilePic = !empty($user['profile_picture_url']) ? htmlspecialchars($user['profile_picture_url']) : 'images/default/defaultUserLogo.jpg';
                ?>
                <img src="<?= $profilePic ?>" alt="Profile" class="rounded mb-2" width="100">
                <input type="file" class="form-control-file" name="profile_picture" accept="image/*">
              </div>

              <!-- Resume -->
              <div class="form-group">
                <label>Resume (PDF)</label><br>
                <?php if (!empty($user['resume_url'])): ?>
                  <a href="<?= htmlspecialchars($user['resume_url']) ?>" target="_blank" class="d-block mb-2">Download current resume</a>
                <?php endif; ?>
                <input type="file" class="form-control-file" name="resume" accept="application/pdf">
              </div>

              <!-- Name and Title -->
              <div class="row">
                <div class="col">
                  <label for="full_name">Full Name</label>
                  <input type="text" class="form-control" id="full_name" name="full_name" value="<?=htmlspecialchars($user['full_name']) ?>" required>
                </div>
                <div class="col">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($user['job_title'] ?? '') ?>" required>
                </div>
              </div>

              <!-- Email & Address -->
              <div class="row">
                <div class="col">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="col">
                  <label for="address">Address</label>
                  <input class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                </div>
              </div>

              <!-- About -->
              <div class="form-group">
                <label for="about">About</label>
                <textarea class="form-control" id="about" name="about"><?= htmlspecialchars($user['about'] ?? '') ?></textarea>
              </div>


              <?php

                if (!isset($_SESSION['user_id'])) {
                    die("User not logged in.");
                }

                $userId = $_SESSION['user_id'];
                $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
                $stmt->execute([$userId]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                $skillsStmt = $conn->prepare("
                    SELECT s.name FROM skills s 
                    JOIN user_skills us ON s.id = us.skill_id 
                    WHERE us.user_id = ?
                ");
                $skillsStmt->execute([$userId]);
                $skills = $skillsStmt->fetchAll(PDO::FETCH_COLUMN);

                $skillsText = implode(', ', $skills);
                ?>
              <!-- Skills -->
              <div class="form-group">
                <label for="skills">Skills</label>
                <input type="text" class="form-control" id="skills" name="skills" value="<?= htmlspecialchars($skillsText ?? '') ?>" placeholder="Ex: HTML, CSS, JavaScript">
                <small class="form-text text-muted">Separate with commas (,)</small>
              </div>

              <!-- Social Links -->
              <div class="row">
                <div class="col">
                  <label for="linkedin_url">LinkedIn URL</label>
                  <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" value="<?= htmlspecialchars($user['linkedin_url'] ?? '') ?>">
                </div>
                <div class="col">
                  <label for="github_url">GitHub URL</label>
                  <input type="url" class="form-control" id="github_url" name="github_url" value="<?= htmlspecialchars($user['github_url'] ?? '') ?>">
                </div>
              </div>

              <!-- Gender & DOB -->
              <div class="row">
                <div class="col">
                  <label for="gender">Gender</label>
                  <select class="form-control" id="gender" name="gender">
                    <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= ($user['gender'] === 'Other' || $user['gender'] === null) ? 'selected' : '' ?>>Other</option>
                  </select>
                </div>
                <div class="col">
                  <label for="date_of_birth">Date of Birth</label>
                  <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($user['date_of_birth'] ?? '') ?>" required>
                </div>
              </div>
            </section>


            <!-- ACTIONS -->
            <div class="actions mt-4">
              <button class="btn btn-secondary" type="reset">Cancel</button>
              <button class="btn btn-primary" type="submit">Save & Publish</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>