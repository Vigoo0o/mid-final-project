<?php
  include './error.php';
  session_start();

  if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo '<div id="popup" style="background: #0ea89b; color: white; padding: 15px; text-align: center;">
    Your account has been created successfully! You can log in now.
    </div>';
  }

  if (isset($_GET['error'])) {
    echo '<div id="popup" style="background: #F44336; color: white; padding: 15px; text-align: center;">
    Invalid email or password
    </div>';;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>  
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WorkNest - Login</title>
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
    <link rel="stylesheet" href="./style/login.css" />
    <link rel="stylesheet" href="./style/main.css" />
  </head>
  <body>
    <nav>
      <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <div class="logo">
            <a href="./index.php">
              <img class="logo" src="./images/logo/logo.png" alt="logo" />
            </a>
          </div>
        </div>
      </div>
    </nav>
    <form class="login" method="POST" action="./handlers/loginHandeler.php" >
      <h2>Login</h2>

      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input
          type="email"
          class="emailInput form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          placeholder="Enter email"
          style="margin-bottom: 15px"
          name="email"
        />

      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input
          type="password"
          class="form-control"
          id="exampleInputPassword1"
          placeholder="Password"
          name="password"
        />
      </div>
      <div class="haveAcc">
        <p>You Don't Have Account?</p>
        <a href="./userSignUp.php">Sign-Up</a>
      </div>
      <a href="">
        <button type="submit" class="btn btn-primary">Login</button>
      </a>
    </form>
    <script src="./js/main.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
  </body>
</html>
