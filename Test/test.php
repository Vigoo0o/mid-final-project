<?php
  include './error.php';
  include 'auth.php';
  include './components.php';
  include './userData.php';
  
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  // function safe($value, $default = "N/A") {
  //   return htmlspecialchars($value ?? $default);
  // }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Test</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../style/all.css" />
    <link rel="stylesheet" href="../style/all.min.css" />
    <link rel="stylesheet" href="../style/bootstrap.min.css" />
    <link rel="stylesheet" href="../style/profile.css" />
    <link rel="stylesheet" href="../style/main.css" />


  </head>

  <body>
  <section>
          <div class="Exper">
            <h1>Working Experience</h1>
            <?php
              $stmt = $conn->prepare("SELECT * FROM experiences WHERE user_id = ?");
              $stmt->execute([$user_id]);
              $experiences = $stmt->fetchAll();
              
                foreach ($experiences as $exp): ?>
                <div class="detalis"><img src="<?= htmlspecialchars($exp['image_path']) ?>" /></div>
                <div class="Job">
                  <h3>
                    <?= htmlspecialchars($exp['job_title']) ?>
                    <?php if (is_null($exp['end_date'])): ?>
                      <span class="Wor"><h2>Working</h2></span>
                    <?php endif; ?>
                  </h3>
                  <span><i class="fa-regular fa-bookmark"></i> <?= htmlspecialchars($exp['employment_type']) ?></span>
                  <span><i class="fa-solid fa-house"></i> <?= htmlspecialchars($exp['company_name']) ?></span>
                  <span><i class="fa-solid fa-calendar"></i>
                    <?= date('M Y', strtotime($exp['start_date'])) ?> -
                    <?= $exp['end_date'] ? date('M Y', strtotime($exp['end_date'])) : 'Present' ?>
                  </span>
                  <p><?= htmlspecialchars($exp['description']) ?></p>
                  <a href="#" class="see-more">see more</a>
                </div>
              <?php endforeach; ?>
          </div>
        </section>
  </body>
</html>
