<?php
  session_start();
  include './db.php';
  include './error.php';
  include './components.php';
  // include './userData.php';

  $query = "SELECT * FROM companies WHERE 1";

  $params = [];

  if (!empty($_GET['search'])) {
    $keyword = "%" . $_GET['search'] . "%";
    $query .= " AND company_name LIKE ?";
    $params[] = $keyword;
  }

  if (!empty($_GET['industry'])) {
    $industry = $_GET['industry'];
    $query .= " AND industry LIKE ?";
    $params[] = $industry;
  }

  $stmt = $conn->prepare($query);
  $stmt->execute($params);

  $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Companies - Home</title>
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
            <li><a  href="./index.php">Home</a></li>
            <li><a  href="./alljobs.php">All Jobs</a></li>
            <li><a class="active" href="./company.php ">Companies</a></li>
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

    <div class="page">
      <div class="container">
        <div class="head">
          <div class="title">
            <h1><span>Companies</span></h1>
          </div>
          <div class="searchFilters">
          <?php
          $industryStmt = $conn->query("SELECT DISTINCT industry FROM companies WHERE industry IS NOT NULL");
          $industries = $industryStmt->fetchAll(PDO::FETCH_COLUMN);
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
                      <select name="industry" class="form-control">
                          <option value="">Industry</option>
                          <?php foreach ($industries as $industry): ?>
                              <option value="<?= htmlspecialchars($industry) ?>" <?= ($_GET['industry'] ?? '') == $industry ? 'selected' : '' ?>>
                                  <?= htmlspecialchars($industry) ?>
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
            <div class="totalResult">
            32 results for <span>'Designer'</span>
            </div>
            <?php

              if(empty($_GET)) {
                $sql = "
                  SELECT 
                  company_id,
                  company_name,
                  logo_url,
                  address,
                  industry
                  FROM companies
                  ORDER BY created_at DESC
                  LIMIT 6";
  
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
              }
            ?>
            <div class="results">
              <?php foreach ($companies as $company): ?>
                  <a href="companyProfile.php?company_id=<?= $company['company_id'] ?>" style="text-decoration: none; color: inherit;">
                <div class="result mb-3">
                <div class="image">
                <img 
                src="<?= htmlspecialchars($company['logo_url']  ?? './images/default/defaultCompanyLogo.png') ?>" 
                alt="<?= htmlspecialchars($company['company_name'] ?? 'Company') ?>" 
                />
                </div>
                <div class="info">
                <div class="row1">
                <div class="name"><?= htmlspecialchars($company['company_name'] ?? 'Company Name') ?></div>
                <div class="tags">
                </div>
                </div>
                <div class="row1">
                <div class="liveIn"><?= htmlspecialchars($company['address'] ?? 'No location specified') ?></div>
                <div class="jobTitle">
                <?= !empty($company['industry']) ? htmlspecialchars($company['industry']) : 'No industry available' ?>
                </div>
                </div>
                <div class="row1">
      
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
        <i class="fa-solid fa-angle-left" id="prevBtn"></i>
        <div class="pages">
        <button class="active">1</button>
        <button>2</button>
        <button>3</button>
        <button>4</button>
        <button>5</button>
        <button>6</button>
        <button>7</button>
        <button>8</button>
        <button>...</button>
        </div>
        <i class="fa-solid fa-angle-right" id="nextBtn"></i>
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
