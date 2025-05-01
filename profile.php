<?php
  include './error.php';
  include 'auth.php';
  include './components.php';
  include './userData.php';
  
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  
  if (isset($_GET['user_id'])) {
    // open backdor SQL Injection
    $user_id = $_GET['user_id'];
  } else if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
  }
  

  $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
  $stmt->execute([$user_id]);
  $user = $stmt->fetch();

  if (!$user) {
  die('User not found.');
  }

  function safe($value, $default = "N/A") {
    return htmlspecialchars($value ?? $default);
  }
?>

<!DOCTYPE html>
<html lang="en">
  <s>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WorkNesr - Profile</title>
    <!-- Lato & Sarabun Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./style/all.css" />
    <link rel="stylesheet" href="./style/all.min.css" />
    <link rel="stylesheet" href="./style/bootstrap.min.css" />
    <link rel="stylesheet" href="./style/main.css" />
    <link rel="stylesheet" href="./style/profile.css" />
    <style>
    </style>
  </s>
  <body>
    <nav>
      <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <div class="logo">
            <a href="./index.php">
              <img class="logo" src="./images/logo/logo.png" alt="logo" />
            </a>
          </div>
                     <ul class="links list-unstyled m-0 d-none d-lg-flex">
            <li><a href="./index.php">Home</a></li>
            <li><a href="./alljobs.php">All Jobs</a></li>
            <li><a href="./company.php ">Companies</a></li>
            <li><a href="./candiates.php">People</a></li>
            <li><a href="./suggestions.php">Suggestions</a></li>
          </ul>
        </div>
        <?php 
          renderAuthButtons();
        ?>
        <div class="dropdown d-block d-lg-none">
          <button class="btn" type="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-bars"></i>
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" class="active" href="./index.html"
                >Home</a
              >
            </li>
            <li><a class="dropdown-item" href="./alljobs.html">All Jobs</a></li>
            <li>
              <a class="dropdown-item" href="./company.html ">Companies</a>
            </li>
            <li><a class="dropdown-item" href="./candiates.html">People</a></li>
            <li>
              <a class="dropdown-item" href="./suggestions.html">Suggestions</a>
            </li>
            <li>
              <button
                type="button"
                class="login-btn btn"
                onclick="openPopup('login')"
                data-bs-toggle="modal"
                data-bs-target="#chooseTypeModal"
              >
                Login
              </button>
              <button
                type="button"
                class="register-btn btn"
                onclick="openPopup('register')"
                data-bs-toggle="modal"
                data-bs-target="#chooseTypeModal"
              >
                Register
              </button>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="home-pag">
      <div class="container">
        <div class="sidebar-container">
          <div class="sidebar-content">
            <div class="profile-section">
              <img src="<?=htmlspecialchars($user['profile_picture_url'] ?? './images/default/defaultUserLogo.jpg')?>" alt="#" />
              <h2><?= htmlspecialchars($user['full_name']) ?: 'No Name' ?></h2>
              <h3><?= htmlspecialchars($user['job_title']) ?: 'No Job Title' ?></h3>
              <p><?= htmlspecialchars(isset($user['bio']) ? $user['bio'] : '') ?: 'No bio added yet.' ?></p>
            </div>
            <div class="profile-links">
              <h3>profile link</h3>
              <a href="#">
              https://worknesr.com/user/<?= $user['user_id'] ?>
              <span><i class="fa-regular fa-copy"></i></span>
            </a>
            </div>
            <div class="profile-links linkedin-link">
              <h3>LinkedIn link</h3>
              <a href="<?= htmlspecialchars($user['linkedin_url'] ?? '') ?: '#' ?>">
                  <?= htmlspecialchars($user['linkedin_url'] ?? '') ?: 'No LinkedIn added' ?>
                <span> <i class="fa-regular fa-copy"></i></span>
              </a>
            </div>
            <div class="profile-links linkedin-link">
              <h3>Github link</h3>
              <a href="<?= htmlspecialchars($user['github_url'] ?? '') ?: '#' ?>">
                  <?= htmlspecialchars($user['github_url'] ?? '') ?: 'No GitHub added' ?>
                <span> <i class="fa-regular fa-copy"></i></span>
              </a>
            </div>
            <div class="profile-links cv-link">
            <h3>CV</h3>
            <?php if (!empty($user['resume_url'])): ?>
              <a href="<?= htmlspecialchars($user['resume_url']) ?>" target="_blank">
                <?= basename($user['resume_url']) ?>
                <!-- <span><i class="fa-regular fa-copy"></i></span> -->
              </a>
            <?php else: ?>
              <a href="/edit-profile.php" title="Upload your CV">
                No CV uploaded
                <!-- <span><i class="fa-solid fa-upload"></i></span> -->
              </a>
            <?php endif; ?>
          </div>
            <!-- <div class="edit-profile">
              <a href="./editUserProfile.php"><i class="fa-solid fa-pen"></i> Edit Profile</a>
            </div> -->
            <?php 
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['user_id']) {
              echo '<div class="edit-profile"><a href="./editUserProfile.php"><i class="fa-solid fa-pen"></i> Edit Profile</a></div>';
            }
            ?>
          </div>
        </div>
        <div class="work-section">
          <section class="about">
            <h1>
              About
            </h1>
            <p>
            <?= htmlspecialchars($user['about'] ?? 'No about section added yet.') ?>
            </p>
          </section>
            <section class="Exper">
              <h1>Working Experience</h1>
          
              <?php 
              $stmt = $conn->prepare("SELECT * FROM experiences WHERE user_id = ?");
              $stmt->execute([$user_id]);
              $experiences = $stmt->fetchAll();
              foreach ($experiences as $exp): ?>
                <div class="detalis">
          
                  <img src="./images/default/defaultCompanyLogo.png" alt="Company Logo" />
                </div>
          
                <div class="Job">
                  <h3>
                    <?= safe($exp['job_title']) ?>
                    <?php if (is_null($exp['end_date'])): ?>
                      <span class="Wor"><h2>Working</h2></span>
                    <?php endif; ?>
                  </h3>

                  <span><i class="fa-regular fa-bookmark"></i> Fulltime</span>
                  <span><i class="fa-solid fa-house"></i> <?= safe($exp['company_name']) ?></span>
                  <span>
                    <i class="fa-solid fa-calendar"></i>
                    <?= date('M Y', strtotime($exp['start_date'])) ?> -
                    <?= $exp['end_date'] ? date('M Y', strtotime($exp['end_date'])) : 'Present' ?>
                  </span>
          
                  <p><?= safe($exp['description']) ?></p>
                  <!-- <a href="#" class="see-more"> see more</a> -->
                </div>
              <?php endforeach; ?>
            </section>
        </div>
      </div>
    </div>
    <?php if (!isset($_GET['user_id'])) { ?>
    <a href="./userDashboard.php" class="btn btn-primary" style="position: fixed;bottom: 20px;right: 20px;">Dashboard</a>
    <?php } ?>
  </body>
</html>
