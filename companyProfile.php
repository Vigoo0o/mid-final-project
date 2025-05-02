<?php
  include 'db.php';
  include 'auth.php';
  include './error.php';
  include './components.php';
  protectPage('company');

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (isset($_GET['update'])) {
    if ($_GET['update'] == 'success') {
      echo '<div id="popup" style="background: #0ea89b; color: white; padding: 15px; text-align: center;">
    Update Successfliy.
    </div>';
    } else {
      echo '<div id="popup" style="background: #F44336; color: white; padding: 15px; text-align: center;">
    Faild To Update.
    </div>';
    }
  }

  if (isset($_GET['jobPost'])) {
    if($_GET['jobPost'] == 'done') {
       echo '<div id="popup" style="background: #0ea89b; color: white; padding: 15px; text-align: center;">
    Job Posted Successfliy.
    </div>';
    } else {
       echo '<div id="popup" style="background: #F44336; color: white; padding: 15px; text-align: center;">
    Faild Post Job.
    </div>';
    }
  }
  
  // $companyId = $_SESSION['company_id'];

  // Check if company viwed hsi profile or view other company profile
  if (isset($_GET['company_id'])) {
    $companyId = $_GET['company_id'];
  } else {
    $companyId = $_SESSION['company_id'];
  }

  $query = "SELECT company_name, description, why_choose, industry, address, website FROM companies WHERE company_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->execute([$companyId]);
  $company = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Company</title>
    <link rel="stylesheet" href="./style/all.css" />
    <link rel="stylesheet" href="./style/all.min.css" />
    <link rel="stylesheet" href="./style/bootstrap.min.css" />
    <link rel="stylesheet" href="./style/home.css" />
    <link rel="stylesheet" href="./style/companyProfile.css" />
    <link rel="stylesheet" href="./style/main.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body style="margin-bottom: 50px;">
    <!-- Modal -->
    <div
      class="modal fade"
      id="chooseTypeModal"
      tabindex="-1"
      aria-labelledby="chooseTypeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="chooseTypeModalLabel">
              Choose Account Type
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body text-center">
            <p>Do you want to continue as a company or a regular user?</p>
            <div class="d-flex justify-content-center gap-3">
              <a
                id="companyLink"
                href="#"
                class="btn"
                style="background-color: var(--main-color); color: white"
                >Company</a
              >
              <a id="userLink" href="#" class="btn btn-light">User</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <nav>
      <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <div class="logo">
            <a href="./index.php">
              <img class="logo" src="./images/logo/logo.png" alt="logo" />
            </a>
          </div>
                     <ul class="links list-unstyled m-0 d-none d-lg-flex">
            <li><a  href="./index.php">Home</a></li>
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
    <div class="container">
      <div class="header">
        <div class="profile-section">
          <img src="./images/defaultBGCompany.png" alt="#" />
        </div>
        <div class="inf-section">
          <div class="name">
            <h1 class="name"><?php echo htmlspecialchars($company['company_name']); ?></h1>
            <p class="industry"><?php echo htmlspecialchars($company['industry']); ?></p>

          </div>
        </div>
        <div class="inf-section2 ">
          <div>
            <p><i class="fa-solid fa-location-dot loaction"></i> <?php echo htmlspecialchars($company['address'] ?? 'No Address Avalabel'); ?></p>

             <p><i class="fa-solid fa-globe site"></i> <a href="<?php echo htmlspecialchars($company['website'] ?? 'Web Site Not Avalabel'); ?>" target="_blank"><?php echo htmlspecialchars($company['website'] ?? 'Web Site Not Avalabel'); ?></a></p>

          </div>
        </div>
      </div>
    </div>
    <div class="container">
      
        <div class="about-section">
          <div class="about-us">
            <h2>About us</h2>
           <p class="about"><?php echo nl2br(htmlspecialchars($company['description'] ?? "About Not Avalabel")); ?></p>

            <div class="why-choose-us">
              <h3>Why choosing us</h3>
              <ul>
                <?php
                  if(!is_null($company['why_choose'])) {
                    $whyLines = explode("\n", $company['why_choose']);
                    foreach ($whyLines as $line) {
                      echo "<li>- " . htmlspecialchars($line) . "</li>";
                    }
                  } else 
                  {
                    echo  '<li>No Data Avalabel</li>';
                  }
                ?>
              </ul>

            </div>
          </div>
          <div class="jop-contener">
            <h2>Recent job openings</h2>
            <?php
              // $companyId = $_SESSION['company_id'];

              $query = "SELECT jobs.title, jobs.salary, companies.company_name, companies.logo_url, jobs.location, jobs.employment_type
                FROM jobs
                INNER JOIN companies ON jobs.company_id = companies.company_id
                WHERE jobs.company_id = ?
                ORDER BY jobs.posted_at DESC 
                LIMIT 3";

              $stmt = $conn->prepare($query);
              $stmt->execute([$companyId]);
              $jobs = $stmt->fetchAll();

              // echo '<pre>';
              // print_r($jobs);
              // echo '</pre>';
            ?>
            <div class="jobs">
              <?php if (count($jobs) == 0) echo 'No Jobs Added Recently!';?>
              <?php foreach ($jobs as $job): ?>
                <div class="job">
                  <div class="head">
                    <div class="image">
                      <img src="<?= $job['logo_url'] ?>" alt="" /> 
                    </div>
                    <div class="jobDetails">
                      <div class="jobTitle"><?= htmlspecialchars($job['title']) ?></div>
                      <div class="jobSalaryExpected">
                        <?= htmlspecialchars($job['salary']) ?>
                      </div>
                    </div>
                  </div>
                  <div class="body">
                    <div class="details">
                      <div class="detail">
                        <div class="icon"><i class="fa-solid fa-building"></i></div>
                        <span><?= htmlspecialchars($job['company_name']) ?></span>
                      </div>
                      <div class="detail">
                        <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
                        <span><?= htmlspecialchars($job['location']) ?></span>
                      </div>
                      <div class="detail">
                        <div class="icon"><i class="fa-solid fa-bookmark"></i></div>
                        <span><?= htmlspecialchars($job['employment_type']) ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <?php if (count($jobs) >= 3) {
            echo '<a href="./recentJobOpenings.php" class="btn" style="background-color: #0ea89b; margin: 50px auto 0; display: block; width: fit-content; color: white; font-weight: 600;">See More</a>'; 
          }?>
          </div>
      </div>
    </div>
    <?php if (!isset($_GET['company_id'])) {
    ?>
    <div class="buttons">
      <a class="btn btn-primary" href="./editCompanyProfile.php">Edit Profile</a>
      <a class="btn btn-success" href="./postNewJob.php">Post New Job</a>
      <a class="btn btn-info" href="./companyDashboard.php">View Applicants </a>
    </div>
    <?php }?>
  </body>
</html>
