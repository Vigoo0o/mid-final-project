<?php
session_start();
include_once './db.php';
include_once './error.php';
include_once './components.php';

$limit = 6; // عدد الشركات لكل صفحة
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Base query for counting total rows
$countQuery = "SELECT COUNT(*) FROM companies WHERE 1";
$countParams = [];

// Base query for fetching companies
$query = "SELECT company_id, company_name, logo_url, address, industry 
          FROM companies WHERE 1";
$params = [];

// Apply filters to both count and main query
if (!empty($_GET['search'])) {
    $keyword = "%" . $_GET['search'] . "%";
    $query .= " AND (company_name LIKE ? OR description LIKE ?)";
    $countQuery .= " AND (company_name LIKE ? OR description LIKE ?)";
    $params[] = $keyword;
    $params[] = $keyword;
    $countParams[] = $keyword;
    $countParams[] = $keyword;
}

if (!empty($_GET['industry'])) {
    $industry = $_GET['industry'];
    $query .= " AND industry = ?";
    $countQuery .= " AND industry = ?";
    $params[] = $industry;
    $countParams[] = $industry;
}

// Add sorting and pagination to main query
$query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
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
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WorkNest - Companies</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./style/all.css" />
    <link rel="stylesheet" href="./style/all.min.css" />
    <link rel="stylesheet" href="./style/bootstrap.min.css" />
    <link rel="stylesheet" href="./style/candiates.css" />
    <link rel="stylesheet" href="./style/main.css" />
</head>
<body>
    <!-- Modal -->
    <div class="modal fade" id="chooseTypeModal" tabindex="-1" aria-labelledby="chooseTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chooseTypeModalLabel">Choose Account Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Do you want to continue as a company or a regular user?</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a id="companyLink" href="#" class="btn" style="background-color: var(--main-color); color: white">Company</a>
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
                    <li><a href="./alljobs.php">All Jobs</a></li>
                    <li><a class="active" href="./company.php">Companies</a></li>
                    <li><a href="./candiates.php">People</a></li>
                    <li><a href="./suggestions.php">Suggestions</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center justify-content-between gap-3">
                <!-- <?php renderAuthButtons(); ?> -->
                <div class="dropdown d-block d-lg-none">
                    <button class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="./index.php">Home</a></li>
                        <li><a class="dropdown-item" href="./alljobs.php">All Jobs</a></li>
                        <li><a class="dropdown-item active" href="./company.php">Companies</a></li>
                        <li><a class="dropdown-item" href="./candiates.php">People</a></li>
                        <li><a class="dropdown-item" href="./suggestions.php">Suggestions</a></li>
                    </ul>
                </div>
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
                                <input type="search" name="search" class="form-control" placeholder="Search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" />
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
                        <?= $totalRows ?> results <?= !empty($_GET['search']) ? 'for <span>"' . htmlspecialchars($_GET['search']) . '"</span>' : '' ?>
                    </div>
                    <div class="results">
                        <?php if (count($companies) == 0): ?>
                            <p>No Companies Found!</p>
                        <?php else: ?>
                            <?php foreach ($companies as $company): ?>
                                <a href="companyProfile.php?company_id=<?= $company['company_id'] ?>" style="text-decoration: none; color: inherit;">
                                    <div class="result mb-3">
                                        <div class="image">
                                            <img src="<?= htmlspecialchars($company['logo_url'] ?? './images/default/defaultCompanyLogo.png') ?>" alt="<?= htmlspecialchars($company['company_name'] ?? 'Company') ?>" />
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
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sidebar">
                    <div class="image">
                        <img src="./images/sideparShape.png" alt="" />
                    </div>
                    <div class="info">
                        <span>Incididunt et magna</span>
                        <p>Incididunt et magna enim mollit quis ut ut enim do ex est irure irure in occaec</p>
                        <button>Get started</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="switchPage">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&<?= http_build_query(array_diff_key($_GET, ['page' => ''])) ?>" class="prevBtn">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
            <?php endif; ?>
            <div class="pages">
                <?php for ($i = 1; $i <= min($totalPages, 8); $i++): ?>
                    <a href="?page=<?= $i ?>&<?= http_build_query(array_diff_key($_GET, ['page' => ''])) ?>" class="<?= ($i == $page ? 'active' : '') ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&<?= http_build_query(array_diff_key($_GET, ['page' => ''])) ?>" class="nextBtn">
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
                <input type="email" placeholder=" Input your email" required />
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