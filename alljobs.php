<?php
  include_once './db.php';
  include_once './error.php';
  include_once './components.php';

  $limit = 6;
  $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
  if ($page < 1) $page = 1;
  $offset = ($page - 1) * $limit;

  // Base query for counting total rows
  $countQuery = "SELECT COUNT(*) 
    FROM jobs 
    WHERE status = 'Open'";
  $countParams = [];

  // Base query for fetching jobs
  $query = "SELECT jobs.*, companies.company_name, categories.category_name, companies.logo_url
    FROM jobs 
    JOIN companies ON jobs.company_id = companies.company_id 
    JOIN categories ON jobs.category_id = categories.category_id 
    WHERE jobs.status = 'Open'";
  $params = [];

  // Apply filters to both count and main query
  if (!empty($_GET['search'])) {
    $keyword = "%" . $_GET['search'] . "%";
    $query .= " AND (jobs.title LIKE ? OR jobs.description LIKE ?)";
    $countQuery .= " AND (jobs.title LIKE ? OR jobs.description LIKE ?)";
    $params[] = $keyword;
    $params[] = $keyword;
    $countParams[] = $keyword;
    $countParams[] = $keyword;
  }

  if (!empty($_GET['location'])) {
    $location = "%" . $_GET['location'] . "%";
    $query .= " AND jobs.location LIKE ?";
    $countQuery .= " AND jobs.location LIKE ?";
    $params[] = $location;
    $countParams[] = $location;
  }

  if (!empty($_GET['industry'])) {
    $industry = $_GET['industry'];
    $query .= " AND jobs.category_id = ?";
    $countQuery .= " AND jobs.category_id = ?";
    $params[] = $industry;
    $countParams[] = $industry;
  }

  if (!empty($_GET['employment_type'])) {
    $jobType = $_GET['employment_type'];
    $query .= " AND jobs.employment_type = ?";
    $countQuery .= " AND jobs.employment_type = ?";
    $params[] = $jobType;
    $countParams[] = $jobType;
  }

  if (!empty($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $query .= " AND jobs.category_id = ?";
    $countQuery .= " AND jobs.category_id = ?";
    $params[] = $category_id;
    $countParams[] = $category_id;
  }

  // Add sorting and pagination to main query
  $query .= " ORDER BY jobs.posted_at DESC LIMIT ? OFFSET ?";
  $params[] = $limit;
  $params[] = $offset;

  // Execute count query
  $countStmt = $conn->prepare($countQuery);
  $countStmt->execute($countParams);
  $totalRows = $countStmt->fetchColumn();
  $totalPages = ceil($totalRows / $limit);

  // Prepare and execute main query
  $stmt = $conn->prepare($query);
  foreach ($params as $index => $param) {
    $stmt->bindValue($index + 1, $param, is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR);
  }
  $stmt->execute();
  $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <!-- <link rel="stylesheet" href="./style/main.css" /> -->
    <link rel="stylesheet" href="./style/candiates.css" />
    <link rel="stylesheet" href="./style/main.css" />
  </head>
  <body>
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
            <li><a href="./index.php">Home</a></li>
            <li><a  class="active" href="./alljobs.php">All Jobs</a></li>
            <li><a href="./company.php ">Companies</a></li>
            <li><a href="./candiates.php">People</a></li>
            <li><a href="./suggestions.php">Suggestions</a></li>
          </ul>
        </div>
        <div class="d-flex align-items-center justify-content-between gap-3">
          <?php 
            // renderAuthButtons();
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
                 renderAuthButtons();
                ?>
              </li> -->
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <div class="page">
      <div class="container">
        <div class="head">
          <div class="title">
            <h1><span>Jobs</span></h1>
          </div>
          <div class="searchFilters">
            <?php
            $locationStmt = $conn->query("SELECT DISTINCT location FROM jobs WHERE location IS NOT NULL");
            $locations = $locationStmt->fetchAll(PDO::FETCH_COLUMN);

            $categoryStmt = $conn->query("SELECT category_id, category_name FROM categories");
            $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

            $employmentTypes = ['Full-Time', 'Part-Time', 'Contract', 'Internship'];
            ?>

          <form class="searchFiltersForm" method="GET" action="">
            <div class="row d-flex justify-content-between align-content-center gap-2">

              <div class="col searchInput">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input
                  type="search"
                  name="search"
                  class="form-control"
                  placeholder="Search"
                  value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                />
              </div>

              <div class="col searchSelect">
                <select name="location" class="form-control">
                  <option value="">Location</option>
                  <?php foreach ($locations as $loc): ?>
                    <option value="<?= htmlspecialchars($loc) ?>" <?= ($_GET['location'] ?? '') == $loc ? 'selected' : '' ?>>
                      <?= htmlspecialchars($loc) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col searchSelect">
                <select name="industry" class="form-control">
                  <option value="">Industry</option>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" <?= ($_GET['industry'] ?? '') == $cat['category_id'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($cat['category_name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col searchSelect">
                <select name="employment_type" class="form-control">
                  <option value="">Employment Type</option>
                  <?php foreach ($employmentTypes as $type): ?>
                    <option value="<?= $type ?>" <?= ($_GET['employment_type'] ?? '') == $type ? 'selected' : '' ?>>
                      <?= $type ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary w-auto border-0" style="background-color: var(--main-color)">Search</button>

            </div>

          </form>

          </div>
        </div>
        <div class="body">
          <div class="content">
           
            <div class="jobs">
              <?php if (count($jobs) == 0) echo 'No Jobs Added Recently!';?>
              <?php foreach ($jobs as $job): ?>
                <a href="jobDetails.php?id=<?= $job['job_id'] ?>" class="job-link">
                   <div class="job">

                  <div class="head">
                    <div class="image">
                      <img src="<?=$job['logo_url']?>" alt="" /> <!-- هنا ممكن تحط اللوجو من اللوجو_url لو حبيت -->
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
                </a>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="sidebar">
            <div class="image">
            <img src="./images/sideparShape.png" alt="" />
            </div>
            <div class="info">
            <span>Incididunt et magna</span>
            <p>
            Incididunt et magna enim mollit quis ut ut enim do ex est irure
            irure in occaec
            </p>
            <button>Get started</button>
            </div>
          </div>
        </div>
      </div>
      <div class="switchPage">
        <!-- <i class="fa-solid fa-angle-left" id="prevBtn"></i> -->
         <?php if ($page > 1): ?>
          <a href="?page=<?= $page - 1 ?>" class="prevBtn">
            <i class="fa-solid fa-angle-left"></i>
          </a>
        <?php endif; ?>
        <div class="pages">
        <!-- <button class="active">1</button> -->
        <?php for ($i = 1; $i <= min($totalPages, 8); $i++): ?>
          <a href="?page=<?= $i ?>" class="<?= ($i == $page ? 'active' : '') ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>
        </div>
        <!-- <i class="fa-solid fa-angle-right" id="nextBtn"></i> -->
        <?php if ($page < $totalPages): ?>
          <a href="?page=<?= $page + 1 ?>" class="nextBtn">
            <i class="fa-solid fa-angle-right"></i>
          </a>
        <?php endif; ?>
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
          <li><a href="./aboutUs.php">About US</a></li>
          <li><a href="./contactUs.php">Contact US</a></li>
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
