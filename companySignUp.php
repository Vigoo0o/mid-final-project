<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WorkNest - Company Sign Up</title>
    <link rel="stylesheet" href="./style/bootstrap.min.css" />
    <link rel="stylesheet" href="./style/main.css" />
    <link rel="stylesheet" href="./style/login.css" />
  </head>
  <body>
    <nav>
      <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
          <a href="./index.html">
            <img class="logo" src="./images/logo.png" alt="logo" />
          </a>
        </div>
      </div>
    </nav>

    <form class="login" method="POST" action="./handlers/companySignUpHandeler.php" >
      <h2>Company Sign Up</h2>

      <div class="form-group">
        <label for="companyName">Company Name</label>
        <input
          id="companyName"
          type="text"
          class="form-control"
          placeholder="Enter company name"
          name="name"
        />
      </div>

      <div class="form-group">
        <label for="industry">Industry</label>
        <input
          id="industry"
          type="text"
          class="form-control"
          placeholder="Enter industry type"
          name="industry"
        />
      </div>

      <div class="form-group">
        <label for="contactPerson">Contact Person</label>
        <input
          id="contactPerson"
          type="text"
          class="form-control"
          placeholder="Enter contact person's name"
          name="contact"
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
        <small id="emailHelp" class="form-text text-muted">
          We'll never share your email with anyone else.
        </small>
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
        <a href="./companyLogin.html">Login</a>
      </div>

      <button type="submit" class="btn btn-primary">
        Create Company Account
      </button>
    </form>

    <script src="./js/main.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
  </body>
</html>
