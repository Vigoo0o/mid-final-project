<?php
  include '../db.php';
  session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $email = trim($_POST['mail']);
        $message = trim($_POST['message']);

        // Prepare and insert into DB
        $stmt = $conn->prepare("INSERT INTO suggestions (name, email, message) VALUES (?, ?, ?)");

        if ($stmt->execute([$name, $email, $message])) {
            // Redirect back or show success
            header("Location: ../suggestions.php?success=1");
            exit();
        } else {
            echo "Error: " . $stmt->errorCode();
        }
  } else {
      header("Location: ../suggestions.php");
      exit();
  }
