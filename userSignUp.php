<?php
  if (isset($_GET['error']) && $_GET['error'] == 'errorEmail') {
    echo '<div id="popup" style="background:#F44336; color: white; padding: 15px; text-align: center;">
    Email already exists.
    </div>';
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
            <a href="./index.html">
              <img class="logo" src="./images/logo/logo.png" alt="logo" />
            </a>
          </div>
        </div>
      </div>
    </nav>
    <form
      class="login"
      action="./handlers/userSignUpHandeler.php"
      method="POST"
    >
      <h2>Create Account</h2>
      <!-- <img class="logo" src="./images/logo.png" alt="logo" /> -->

      <div class="row">
        <div class="col">
          <label for="firstName">First Name</label>
          <input
            id="firstName"
            type="text"
            class="form-control"
            placeholder="First name"
            name="firstName"
          />
        </div>
        <div class="col">
          <label for="lastName">last Name</label>

          <input
            id="lastName"
            type="text"
            class="form-control"
            placeholder="Last name"
            name="lastName"
          />
        </div>
      </div>

      <div class="form-group mb-1">
        <label for="jobTitle">job Title</label>
        <input
          type="text"
          class="jobTitleInbut form-control"
          id="jobTitle"
          placeholder="Job Title"
          name="jobTitle"
        />
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input
          type="email"
          class="emailInput form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          placeholder="Enter email"
          name="email"
        />
        <small id="emailHelp" class="form-text text-muted"
          >We'll never share your email with anyone else.</small
        >
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
        <p>Already have an account?</p>
        <a href="./userLogin.html">Login</a>
      </div>
      <a href="">
        <button type="submit" class="btn btn-primary">Create Account</button>
      </a>
    </form>
    <script src="./js/main.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
  </body>
</html>
