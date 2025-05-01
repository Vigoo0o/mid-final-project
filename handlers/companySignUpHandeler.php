<?php
include_once '../error.php';
include_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
  $name = htmlspecialchars(trim($_POST['name']));
  $industry = htmlspecialchars(trim($_POST['industry']));
  // $phone = htmlspecialchars(trim($_POST['contact']));
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

  // echo '<br>' . $name . '<br>';
  // echo '<br>' . $industry . '<br>';
  // echo '<br>' . $contact . '<br>';
  // echo '<br>' . $email . '<br>';
  // echo '<br>' . $password . '<br>';

  // Check If The Company Is Already Registered
  $stmt = $conn->prepare("SELECT company_id FROM companies WHERE email = :email");
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    header("Location: " . "../companySignUp.php" . '?error=error');
    exit;
  }

  // Insert new user
  $stmt = $conn->prepare("INSERT INTO companies (company_name, email, password, industry) 
  VALUES (:name, :email, :password, :industry)");


  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':industry', $industry);
  // $stmt->bindParam(':phone', $phone);
  
  if ($stmt->execute()) {
    header("Location: ../login.php?status=success");
    exit;
  } else {
    header("Location: ../login.php?status=error");
    exit;
  }
}