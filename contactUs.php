<?php
  if(isset($_GET['massage'])) {
    if ($_GET['massage'] == '1') {
      echo '<div id="popup" style="background:#0ea89b; color: white; padding: 15px; text-align: center;">
      Massage Send Succsesfuly.
      </div>';
    }
  }
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
    <link rel="stylesheet" href="./style/main.css" />
    <link rel="stylesheet" href="./style/contactUs.css" />
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
            <a href="./index.html">
              <img class="logo" src="./images/logo/logo.png" alt="logo" />
            </a>
          </div>
          <ul class="links list-unstyled m-0 d-none d-lg-flex">
            <li><a href="./index.html">Home</a></li>
            <li><a href="./alljobs.html">All Jobs</a></li>
            <li><a href="./company.html ">Companies</a></li>
            <li><a href="./candiates.html">People</a></li>
            <li><a href="./suggestions.html">Suggestions</a></li>
          </ul>
        </div>
        <!-- <div class="icons d-flex align-items-center justify-content-between">
          <a class="notification-icon" href="./notifications.html">
            <i class="fa-regular fa-bell"></i>
          </a>
          <a
            class="profile-icon d-flex justify-content-between align-items-center"
            href="./profile.html"
          >
            <img
              class="profile-image"
              src="./images/profile-image.png"
              alt=""
            />
            <i class="fa-solid fa-chevron-down"></i>
          </a>
        </div> -->
        <div
          class="loginAndRegister d-flex align-items-center justify-content-between gap-2"
        >
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
        </div>
        <!-- <div class="burgerIcon d-none">
          <i class="fa-solid fa-bars"></i>
        </div> -->

        <div class="dropdown d-block d-lg-none">
          <button class="btn" type="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-bars"></i>
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="./index.html">Home</a>
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
    <!-- Start Contact -->
    <div class="contact">
      <div class="container">
        <div class="main-heading">
          <h2>Contact Us</h2>
          <p>
            Get in touch with us for any inquiries or support. We're here to
            help!
          </p>
        </div>
        <div class="content">
          <form action="./handlers/contactHandler.php" method="POST">
            <input
              class="main-input"
              type="text"
              name="name"
              placeholder="Your Name"
            />
            <input
              class="main-input"
              type="email"
              name="email"
              placeholder="Your Email"
            />
            <textarea
              class="main-input"
              name="message"
              placeholder="Your Message"
            ></textarea>
            <input type="submit" value="Send Message" />
          </form>
          <div class="info">
            <h4>Get In Touch</h4>
            <span class="phone">+00 123.456.789</span>
            <span class="phone">+00 123.456.789</span>
            <h4>Where We Are</h4>
            <address>
              Awesome Address 17<br />New York, NYC<br />123-4567-890<br />USA
            </address>
          </div>
        </div>
      </div>
    </div>
    <!-- End Contact -->
    <footer>
      <div class="footer-logo">
        <img src="./images/logo.png" alt="#" />
      </div>
      <div class="footer-section">
        <h3>Product</h3>
        <ul>
          <li><a href="./alljobs.html">All Jobs</a></li>
          <li><a href="#">Companies</a></li>
          <li><a href="./candiates.html">Candidates</a></li>
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
