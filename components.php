<?php

// <button
//   type="button"
//   class="login-btn btn"
//   onclick="openPopup(\'login\')"
//   data-bs-toggle="modal"
//   data-bs-target="#chooseTypeModal"
// >
//   Login
// </button>
function renderAuthButtons()
{
    if (!isset($_SESSION['user_type'])) {
        echo '
        <div class="loginAndRegister d-flex align-items-center justify-content-between gap-2">
            <a class="btn btn-primary" href="./login.php" style="    background-color: var(--main-color);border: none;">Login</a>

            <button
              type="button"
              class="register-btn btn"
              onclick="openPopup(\'register\')"
              data-bs-toggle="modal"
              data-bs-target="#chooseTypeModal"
            >
              Register
            </button>
        </div>';
    } else {
        $profilePage = ($_SESSION['user_type'] === 'company') ? './companyProfile.php' : './profile.php';
        
        echo '
        <a class="profilePage" href="' . $profilePage . '">
            <i class="fa-solid fa-user"></i>
        </a>';
    }
}
