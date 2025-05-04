<?php
  include 'auth.php';
  include './db.php';
  // include './error.php';
  // protectPage('company');

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (isset($_GET['already_applied']) && $_GET['already_applied'] == 1) {
      // echo "You have already applied for this job.";
      echo '<div id="popup" style="background: #0ea89b; color: white; padding: 15px; text-align: center;">
    You have already applied for this job.
    </div>';
  }

  if (isset($_GET['applied']) && $_GET['applied'] == 1) {
      // echo "You have already applied for this job.";
      echo '<div id="popup" style="background: #0ea89b; color: white; padding: 15px; text-align: center;">
    Applied Succsesfuly.
    </div>';
  }



  if (!isset($_GET['id'])) {
    echo "Job not found.";
    exit;
  }

  $jobId = $_GET['id'];

  $query = "SELECT jobs.*, companies.company_name, companies.logo_url, companies.industry, companies.address
          FROM jobs
          JOIN companies ON jobs.company_id = companies.company_id
          WHERE jobs.job_id = :job_id";


  $stmt = $conn->prepare($query);
  $stmt->execute([':job_id' =>$jobId]);
  $job = $stmt->fetch();

  // echo '<pre>';
  // print_r($job);
  // echo '</pre>';

  if (!$job) {
    echo "Job not found.";
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Details</title>
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
    <link rel="stylesheet" href="./style/postNewJob.css" />
    <link rel="stylesheet" href="./style/main.css" />
    <link rel="stylesheet" href="./style/candiates.css" />
    <style>
      /* .content div section {
        width: 100%;
      } */

      .details .icon {
        margin-right: 15px;
      }
    </style>
  </head>
  <body>
    <div class="page">
      <div class="container">
        <div class="head d-flex align-items-center justify-content-between">
          <h2>Job Details</h2>
        </div>
        <div class="content d-flex justify-content-between">
          <div class="sidebar">
            <div class="postJobTag">
              <ul>
                <a href=""> <li>Company Info</li> </a>
                <!-- <a href=""> <li>Company info</li> </a> -->
                <a href=""><li>Job Description</li>
                <a href=""><li>Job Requerment</li>
                </a>
              </ul>
            </div>
          </div>
          <div  class=" w-100">
            <section>
              <h3>Company Info</h3>
                <div class="result">
                <div class="image">
                <img 
                src="<?php echo $job['logo_url'] ?? './images/default/defaultCompanyLogo.png'; ?>" alt="Company Logo"
                />
                </div>
                <div class="info">
                <div class="row1">
                <div class="name"><?php echo htmlspecialchars($job['company_name']); ?></div>
                <div class="tags">
                </div>
                </div>
                <div class="row1">
                <div class="liveIn"><?php echo htmlspecialchars($job['address'] ?? 'No Address Avalabil'); ?></div>
                <div class="jobTitle">
                <?php echo htmlspecialchars($job['industry']); ?>
                </div>
                </div>

                </div>
                </div>
            </section>
            <section>
              <h3>Job Info</h3>
                  <div class="job">

                  <div class="head m-0">
                    <div class="image">
                      <img src="./images/companyLogo3.png" alt="" /> <!-- هنا ممكن تحط اللوجو من اللوجو_url لو حبيت -->
                    </div>
                    <div class="jobDetails">
                      <div class="jobTitle"><span class="fw-bold" style="font-size: 15px;">Job Title:</span> <?= htmlspecialchars($job['title']) ?></div>
                      <div class="jobSalaryExpected"><span class="fw-bold" style="font-size: 15px;">Expected Salary:</span> 
                        <?= htmlspecialchars($job['salary']) ?>
                      </div>
                    </div>
                  </div>
                  <div class="body">
                    <div class="details">
                      <div class="detail d-flex   align-items-center">
                        <div class="icon "><i class="fa-solid fa-building"></i></div>
                        <span><?= htmlspecialchars($job['company_name']) ?></span>
                      </div>
                      <div class="detail d-flex  align-items-center">
                        <div class="icon "><i class="fa-solid fa-location-dot"></i></div>
                        <span><?= htmlspecialchars($job['location']) ?></span>
                      </div>
                      <div class="detail d-flex  align-items-center">
                        <div class="icon "><i class="fa-solid fa-bookmark"></i></div>
                        <span><?= htmlspecialchars($job['employment_type']) ?></span>
                      </div>
                    </div>
                  </div>
                </div>
            </section>
            <section>
              <h3>Job Description</h3>
              <p><?php echo htmlspecialchars($job['description']); ?></p>
            </section>
            <section>
              <h3 >Job Requerment</h3>
              <p>
                <?php echo htmlspecialchars($job['requirements']); ?>
              </p>
            </section>
            <?php if($_SESSION['user_type']  == 'user') { ?>
              <section>

                <form action="handlers/applyJobHandler.php" method="POST">
                  <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
    
                  <div class="form-group mb-4">
                    <label for="cover_letter">Cover Letter</label>
                    <textarea name="cover_letter" id="cover_letter" class="form-control" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary d-block" style="margin-left: auto;">Apply Now</button>
    
                </form>
              </section>

            <?php }?>
            
          </div>
        </div>
        </div>
      </div>
    </div>
    <script src="./js/main.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
  </body>
</html>
