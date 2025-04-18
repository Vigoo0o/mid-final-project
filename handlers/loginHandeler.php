<?php

  session_start();
  include '../db.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = trim($_POST['password']);

    // echo $email;

    // Check If User Exist
    $stmt = $conn->prepare("SELECT id, first_name, last_name, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check If Password Corect And Set Data In Session
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_type'] = 'user'; 
      $_SESSION['user_firstName'] = $user['first_name']; 
      $_SESSION['user_lastName'] = $user['last_name']; 
      header("Location: ../index.php");
      exit;
    }

     // Check If Company Exist
    $stmt = $conn->prepare("SELECT id, name, password FROM companies WHERE email = ?");
    $stmt->execute([$email]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check If Password Corect And Set Data In Session
  if ($company && password_verify($password, $company['password'])) {
    $_SESSION['company_id'] = $company['id'];
    $_SESSION['user_type'] = 'company'; 
    $_SESSION['company_name'] = $company['name']; 
    header("Location: ../index.php");
    exit;
  } 

  $error = "error";
}

if (!empty($error)) {
  header("Location: ../login.php" . "?error");
  exit;
}