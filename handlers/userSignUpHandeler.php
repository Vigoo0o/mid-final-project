<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
  $firstName = htmlspecialchars(trim($_POST['firstName']));
  $lastname = htmlspecialchars(trim($_POST['lastName']));
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

  // echo '<br>' . 'First Name: ' . $firstName . '<br>';
  // echo 'Last Name: ' . $lastname . '<br>';
  // echo 'Email: ' . $email . '<br>';
  // echo 'Password: ' . $password . '<br>';

  // Check If The User Is Already Registered
  $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    header("Location: " . "../userSignUp.php" . '?error=error');
    // header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }

  // Insert new user
  $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) 
  VALUES (:firstName, :lastName, :email, :password)");

  $stmt->bindParam(':firstName', $firstName);
  $stmt->bindParam(':lastName', $lastname);
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