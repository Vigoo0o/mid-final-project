<?php
include '../db.php';
include '../error.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $message = trim($_POST["message"]);

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