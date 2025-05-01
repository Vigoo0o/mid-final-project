<?php
include '../db.php';
include '../error.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $message = trim($_POST["message"]);

  // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //   echo "Email Not Valid";
  //   exit;
  // }

  $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
  $stmt->execute([
    $name,
    $email,
    $message
  ]);

  if ($stmt->execute()) {
    header("Location: ../contactUs.php?massage=1");
    exit;
  }
}