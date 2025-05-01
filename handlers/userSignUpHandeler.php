<?php
include '../db.php';
include '../error.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
  // $userName = htmlspecialchars(trim($_POST['username']));
  $fullName = htmlspecialchars(trim($_POST['firstName'])) . ' ' . htmlspecialchars(trim($_POST['lastName']));
  $jobTitle = htmlspecialchars(trim($_POST['jobTitle']));
  $email = filter_var(trim(string: $_POST['email']), FILTER_SANITIZE_EMAIL);
  $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

  // Check If The User Is Already Registered
  $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = :email");
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $resultEmail = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($resultEmail) {
    header("Location: " . "../userSignUp.php" . '?error=errorEmail');
    // header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }

  // Check If The Username Is Already Registered
  $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = :email");
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $resultUsername = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($resultUsername) {
    header("Location: " . "../userSignUp.php" . '?error=errorEmail');
    // header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }

  // Insert new user
  $stmt = $conn->prepare("INSERT INTO users ( full_name, job_title, email, password) 
  VALUES ( :fullname, :jobTitle, :email, :password)");

  // $stmt->bindParam(':username', $userName);
  $stmt->bindParam(':fullname', $fullName);
  $stmt->bindParam(':jobTitle', $jobTitle);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $password);

  if ($stmt->execute()) {
    header("Location: ../login.php?status=success");
    exit;
  } else {
    // echo 'error' . '<br>';
    echo "Error: " . $stmt->errorCode();
  }
}