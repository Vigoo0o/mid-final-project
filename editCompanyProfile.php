<?php
  include './error.php';
  include 'auth.php';
  include './components.php';
  include './userData.php';
  
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $companyId = $_SESSION['company_id'];

  $query = "SELECT company_name, email, description, why_choose, industry, address, website FROM companies WHERE company_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->execute([$companyId]);
  $company = $stmt->fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <!-- <link rel="stylesheet" href="./style/editUserProfile.css"> -->
    <link rel="stylesheet" href="./style/all.css" />
    <link rel="stylesheet" href="./style/all.min.css" />
    <link rel="stylesheet" href="./style/bootstrap.min.css" />
    <link rel="stylesheet" href="./style/postNewJob.css" />
    <link rel="stylesheet" href="./style/main.css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"> -->
</head>
<body>

    <div class="page">
      <div class="container">
        <div class="head d-flex align-items-center justify-content-between">
          <h2>Edit Profile</h2>
        </div>
        <div class="content">

          <div class="content">
            <form action="./handlers/editCompanyProfileHandeler.php" method="POST" enctype="multipart/form-data">
                <section class="userInfoGeneral">
                  <h3>General</h3>
                    <div class="avatar">
                        <div class="form-group">
                            <label>Profile Picture</label><br>
                            <?php
                            $profilePic = !empty($user['profile_picture_url'])
                                ? htmlspecialchars($user['profile_picture_url'])
                                : 'images/default/defaultCompanyLogo.png';
                            ?>
                            <img src="<?= $profilePic ?>" alt="Profile" class="rounded mb-2" width="100">
                            <input type="file" class="form-control-file" name="profile_picture" accept="image/*">
                        </div>
                    </div>

                    <div class="row">
                            <div class="col">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= isset($company['company_name']) ? htmlspecialchars($company['company_name']) : '' ?>" required>
                            </div>
                        <div class="col">
                                <label for="industry">Industry</label>
                                <input type="text" class="form-control" id="industry" name="industry" value="<?= isset($company['industry']) ? htmlspecialchars($company['industry']) : '' ?>" required>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?=  isset($company['email']) ? htmlspecialchars($company['email']) : '' ?>" required>
                        </div>
                        <div class="col">
                            <label for="address">Address</label>
                            <input class="form-control" id="address" name="address" value="<?= isset($company['address']) ? htmlspecialchars($company['address']) : '' ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="site">Web Site</label>
                            <input class="form-control" id="site" name="site" value="<?= isset($company['website']) ?  htmlspecialchars($company['website']) : '' ?>" >
                    </div>

                    <div class="form-group mb-1">
                        <label for="about">About</label>
                        <textarea class="form-control" id="about" name="about"><?= isset($company['description']) ? htmlspecialchars($company['description']) : '' ?></textarea>
                    </div>
                      <div class="form-group mb-1">
                        <label for="why_choies">Why Choies Us</label>
                        <textarea class="form-control" id="why_choies" name="why_choies"><?=  isset($company['why_choose']) ? htmlspecialchars($company['why_choose']) : '' ?></textarea>
                      </div>
                     </div> 
                </section>
                <div class="actions">
                  <button class="btn btn-primary" type="submit">Cancel</button>
                  <button class="btn btn-primary" type="submit">
                    Save & publish
                  </button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
