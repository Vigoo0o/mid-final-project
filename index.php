<?php
  include './db.php';
  include './error.php';
  include './components.php';
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WorkNest - Home</title>
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
    <link rel="stylesheet" href="./style/home.css" />
    <link rel="stylesheet" href="./style/main.css" />
    <style>
      .slider-wrapper {
  overflow: hidden;
  width: 1060px; 
}

.sliderTrack {
  display: flex;
  gap: 14px;
  transition: transform 0.5s ease;
}

    </style>

  </head>
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
            <li><a class="active" href="./index.php">Home</a></li>
            <li><a href="./alljobs.php">All Jobs</a></li>
            <li><a href="./company.php ">Companies</a></li>
            <li><a href="./candiates.php">People</a></li>
            <li><a href="./suggestions.php">Suggestions</a></li>
          </ul>
        </div>
        <div class="d-flex align-items-center justify-content-between gap-3">
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
              <li><a class="dropdown-item" href="./alljobs.php">All Jobs</a></li>
              <li>
                <a class="dropdown-item" href="./company.php ">Companies</a>
              </li>
              <li><a class="dropdown-item" href="./candiates.php">People</a></li>
              <li>
                <a class="dropdown-item" href="./suggestions.php">Suggestions</a>
              </li>
              <!-- <li>
                <?php 
                 // renderAuthButtons();
                ?>
              </li> -->
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <?php
      // Get Category Job Related Count
      $query = "SELECT COUNT(*) AS open_jobs_count
        FROM jobs
        WHERE status = 'Open'";


      $stmt = $conn->prepare($query);
      $stmt->execute();
      $jobsCoutn = $stmt->fetch();
    ?>
    <div class="landing">
      <div
        class="container h-100 d-flex justify-content-between align-items-center"
      >
        <div class="info">
          <h1><span class="numberOfJobs"><?php echo $jobsCoutn['open_jobs_count'] ?> Jobs</span> For You</h1>
          <p>
            Non enim eu excepteur cupidatat consectetur do ea est reprehenderit
            incididunt irure veniam cupidatat est non amet. Enim duis aute
            tempor laboris ipsum dolore non.
          </p>
          <a class="btn btn-primary" href="./alljobs.php">Explore now</a>
        </div>
        <div class="shape">
          <img class="person1" src="./images/homeScreenShape/shapeImage1.png" alt="" />
          <img class="person2" src="./images/homeScreenShape/shapeImage2.png" alt="" />
          <img class="statistic2" src="./images/homeScreenShape/shapeImage3.png" alt="" />
          <img class="statistic1" src="./images/homeScreenShape/shapeImage4.png" alt="" />
          <img class="locationIcon" src="./images/homeScreenShape/shapeImage5.png" alt="" />
        </div>
      </div>
    </div>
      <div class="jobExplore">
      <div class="container">
        <div class="headTitel">
          Explore More
          <div class="primaryWord">jobs</div>
        </div>
        <!-- <form class="jobSearchForm text-center" action="">
          <input class="border-0" type="search" name="jobSearch" id="" />
          <button class="border-0" type="button">Search</button>
        </form> -->
        <?php 
          $colors = [
            "#ecfdfc",
            "#fff6f0",
            "#f6f1fd",
            "#fdf1fd"
          ];

          // Get Category Details
          $query = "SELECT 
              c.category_id, 
              c.category_name, 
              c.icon_url, 
              COUNT(CASE WHEN j.status != 'Closed' THEN 1 END) AS jobs_count
          FROM 
              categories c
          LEFT JOIN 
              jobs j ON c.category_id = j.category_id
          GROUP BY 
              c.category_id, c.category_name, c.icon_url
          ORDER BY 
              c.category_name ASC";

          $stmt = $conn->prepare($query);
          $stmt->execute();
          $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="slider-container categoresSlider d-flex justify-content-center align-items-center">
          <i class="fa-solid fa-angle-left" id="prevBtn"></i>

          <div class="slider-wrapper">
            <div class="sliderTrack">
              <?php foreach ($categories as $index => $cat): ?>
                <?php $color = $colors[$index % count($colors)]; ?>
                <a href="./alljobs.php?category_id=<?= $cat['category_id'] ?>">
                  <div class="categore" style="background-color: <?= $color ?>; width: 250px;">
                    <div class="categoreName"><?= htmlspecialchars($cat['category_name']) ?></div>
                    <span><span class="countOfJobs"><?= (int)$cat['jobs_count'] ?></span> jobs</span>
                  </div>
                </a>
              <?php endforeach; ?>
            </div>
          </div>

          <i class="fa-solid fa-angle-right" id="nextBtn"></i>
        </div>

      </div>
    </div>
    <script>
      const sliderTrack = document.querySelector('.sliderTrack');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');

      let currentPosition = 0;
      const cardWidth = 264;
      const visibleCards = 4;

      nextBtn.addEventListener('click', () => {
        const totalCards = document.querySelectorAll('.sliderTrack > a').length;
        const maxPosition = totalCards - visibleCards;

        if (currentPosition < maxPosition) {
          currentPosition++;
          sliderTrack.style.transform = `translateX(-${cardWidth * currentPosition}px)`;
        }
      });

      prevBtn.addEventListener('click', () => {
        if (currentPosition > 0) {
          currentPosition--;
          sliderTrack.style.transform = `translateX(-${cardWidth * currentPosition}px)`;
        }
      });
    </script>
    <?php
      $sql = "
        SELECT 
            j.*, 
            c.company_name AS company_name, 
            c.logo_url AS company_logo
        FROM jobs j
        JOIN companies c ON j.company_id = c.company_id
        WHERE j.status = 'Open'
        ORDER BY j.posted_at DESC
        LIMIT 6 ";

      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
    <div class="latestJobs">
      <div class="container">
        <div class="headTitel">
          <div class="primaryWord">Latest Jobs</div>
          <p>Exercitation dolore reprehender it fugi</p>
        </div>
        <div class="jobs">
          <?php foreach ($jobs as $job): ?>
              <a href="jobDetails.php?id=<?= $job['job_id'] ?>" style="text-decoration: none; color: inherit;">

            <div class="job">
              <div class="head">
                <div class="image">
                  <img src="<?= htmlspecialchars($job['company_logo'] ?? './images/default/defaultCompanyLogo.png')?> " alt="<?= htmlspecialchars($job['company_name']) ?>" />
                </div>
                <div class="jobDetails">
                  <div class="jobTitle"><?= htmlspecialchars($job['title']) ?></div>
                  <div class="jobSalaryExpected">
                    <?= $job['salary'] ? "$" . $job['salary']  : "Negotiable" ?>
                  </div>
                </div>
                <?php if (strtolower($job['employment_type']) == 'full-time'): ?>
                  <div class="tag"><span>Hot</span></div>
                <?php endif; ?>
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
            </a>
          <?php endforeach; ?>
        </div>
        <a href="./alljobs.php">
          <button type="button" class="btn btn-primary">See More</button>
        </a>
      </div>
    </div>

    <?php
      $sql = "
        SELECT 
          user_id, 
          full_name, 
          job_title, 
          profile_picture_url, 
          resume_url 
        FROM users 
        LIMIT 3";

      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $usersWithCV = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="cvs">
      <div class="container">
        <div class="headTitel">
          <div class="primaryWord">CVs</div>
          <p>Exercitation dolore reprehender it fugi</p>
        </div>
        <div class="content">
          <?php foreach ($usersWithCV as $user): ?>
            <a href="./profile.php?user_id=<?= $user['user_id'] ?>">
              <div class="cv">
                <div class="image text-center">
                  <img 
                    src="<?= htmlspecialchars($user['profile_picture_url'] ?? './images/default/defaultUserLogo.jpg') ?>" 
                    alt="<?= htmlspecialchars($user['full_name']) ?>" 
                    width="200px" class="rounded-circle"/>
                </div>
                <div class="info">
                  <div class="profile">
                    Profile: <span class="name"><?= htmlspecialchars($user['full_name']) ?></span>
                  </div>
                  <div class="jogTitle">
                    Job Title: <span class="title"><?= htmlspecialchars($user['job_title']) ?></span>
                  </div>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
        <a href="candiates.php">
          <button type="button" class="btn btn-primary">See More</button>
        </a>
      </div>
    </div>

    <footer>
      <div class="footer-logo">
        <img src="./images/logo/logo.png" alt="#" />
      </div>
      <div class="footer-section">
        <h3>Product</h3>
        <ul>
          <li><a href="./alljobs.php">All Jobs</a></li>
          <li><a href="./company.php">Companies</a></li>
          <li><a href="./candiates.php">Candidates</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Resources</h3>
        <ul>
          <li><a href="#">Blog</a></li>
          <li><a href="#">User guides</a></li>
          <li><a href="#">Webinars</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Company</h3>
        <ul>
          <li><a href="./aboutUs.html">About US</a></li>
          <li><a href="./contactUs.html">Contact US</a></li>
        </ul>
      </div>
      <div class="footer-subscribe">
        <h3>Subscribe to our newsletter</h3>
        <p>For product announcements and exclusive insights</p>
        <form>
          <input
            type="email"
            placeholder=" Input your email"
            required
            invalid
          />
          <button type="submit">Subscribe</button>
        </form>
      </div>

      <div class="footer-social">
        <a class="twitter" href="#"><i class="fa-brands fa-twitter"></i></a>
        <a class="facebook" href="#"><i class="fa-brands fa-facebook"></i></a>
        <a class="linkedin" href="#"><i class="fa-brands fa-linkedin"></i></a>
        <a class="youtube" href="#"><i class="fa-brands fa-youtube"></i></a>
      </div>
      <div class="language-selector">
        <select>
          <option>English</option>
          <option>Arabic</option>
        </select>
      </div>
    </footer>
    <script src="./js/main.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
  </body>
</html>
