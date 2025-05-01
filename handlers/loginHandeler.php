<?php

  session_start();
  include '../db.php';
  include '../error.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = trim($_POST['password']);

    // echo $email;

    // Check If User Exist
    $stmt = $conn->prepare("SELECT user_id, full_name, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check If Password Corect And Set Data In Session
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['user_type'] = 'user'; 
      $_SESSION['user_fullname'] = $user['full_name']; 
      header("Location: ../index.php");
      exit;
    }

     // Check If Company Exist
    $stmt = $conn->prepare("SELECT company_id, company_name, password FROM companies WHERE email = ?");
    $stmt->execute([$email]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check If Password Corect And Set Data In Session
  if ($company && password_verify($password, $company['password'])) {
    $_SESSION['company_id'] = $company['company_id'];
    $_SESSION['user_type'] = 'company'; 
    $_SESSION['company_name'] = $company['company_name']; 
    header("Location: ../index.php");
    exit;
  } 

  $error = "error";
}

if (!empty($error)) {
  header("Location: ../login.php" . "?error");
  exit;
}