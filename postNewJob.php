<?php
  include 'auth.php';
  include 'db.php';
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
    <link rel="stylesheet" href="./style/postNewJob.css" />
    <link rel="stylesheet" href="./style/main.css" />
  </head>
  <body>
    <div class="page">
      <div class="container">
        <div class="head d-flex align-items-center justify-content-between">
          <h2>Post a new job</h2>
        </div>
        <div class="content d-flex justify-content-between">
          <div class="sidebar">
            <div class="postJobTag">
              <ul>
                <a href=""> <li>Job info</li> </a>
                <a href=""><li>Receive Application</li>
                </a>
              </ul>
            </div>
          </div>
          <form class="content" action="./handlers/postNewJobHandler.php" method="POST">
            <section class="jobInfoSection">
              <h3>Job Information</h3>
                <div class="form-group">
                  <label for="JobTitle">Job title</label>
                  <input
                    type="text"
                    class="form-control"
                    id="JobTitle"
                    placeholder="Ex: Graphic Designer "
                    name="jobTitle"
                    required
                  />
                </div>
                <div class="row">
                  <div class="col">
                    <label for="jobLocation">Job Location</label>

                    <input
                      id="jobLocation"
                      type="text"
                      class="form-control"
                      placeholder="Ex: Remotle"
                      name="jobLocation"
                      required
                    />
                  </div>
                  <div class="col">
                    <label for="employmentType">Employment Type</label>
                    <select
                      id="employmentType"
                      name="employmentType"
                      class="form-control"
                      required
                    >
                      <option value="">Select Employment Type</option>
                      <option value="Full-Time">Full-Time</option>
                      <option value="Part-Time">Part-Time</option>
                      <option value="Contract">Contract</option>
                      <option value="Internship">Internship</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <label for="jobSalary">Salary range ($)</label>
                    <input
                      id="jobSalary"
                      type="text"
                      class="form-control"
                      placeholder="Ex: 90,000 - 110,000"
                      name="salaryRange"
                      required
                    />
                  </div>
                  <?php
                    $query = "SELECT category_id, category_name FROM categories ORDER BY category_name ASC";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  ?>
                  <div class="col">
                    <label for="jobCategory">Job Categore</label>
                    <select
                      id="jobCategory"
                      name="jobCategory"
                      class="form-control"
                      required
                    >
                      <option value="">Select Job Category</option>
                      <?php foreach ($categories as $cat): ?>
                      <option value="<?= htmlspecialchars($cat['category_id']) ?>">
                        <?= htmlspecialchars($cat['category_name']) ?>
                      </option>
                    <?php endforeach; ?>
                    <option value="other">Other</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="jobDescription">Job Description</label>
                  <textarea
                    class="jobDescription"
                    name="jobDescription"
                    id="jobDescription"
                    type="text"
                    required
                  ></textarea>
                </div>
                <div class="form-group">
                  <label for="jobRequerment">Job Requerment</label>
                  <textarea
                    class="jobRequerment"
                    name="jobRequerment"
                    id="jobRequerment"
                    type="text"
                    required
                  ></textarea>
                </div>
            </section>
            <section class="receiveApplication">
              <h3>Receive Application</h3>
                <div class="row">
                  <div
                    class="col d-flex align-items-center justify-content-evenly"
                  >
                    <div class="form-check">
                      <input
                        class="form-check-input p-1"
                        type="radio"
                        name="receiveApplicationMethod"
                        id="exampleRadios1"
                        value="email"
                        checked
                      />
                      <label class="form-check-label " for="exampleRadios1">
                        Email
                      </label>
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input p-1"
                        type="radio"
                        name="receiveApplicationMethod"
                        id="exampleRadios2"
                        value="external_web"
                      />
                      <label class="form-check-label " for="">
                        External Web
                      </label>
                    </div>
                  </div>
                  <div class="col">
                    <label for="companyEmail">Email</label>

                    <input
                      type="text"
                      class="form-control"
                      placeholder="Ex: exampale@gmail.com"
                      id="companyEmail"
                      name="appEmail"
                    />
                  </div>
                </div>
            </section>
            <div class="actions">
              <button class="btn btn-primary" type="">
                <a href="./companyProfile.php">Cancel</a>
              </button>
              <button class="btn btn-primary" type="submit">
                Save & publish
              </button>
            </div>
          </form>
        </div>
        </div>
      </div>
    </div>
    <script src="./js/main.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
  </body>
</html>
