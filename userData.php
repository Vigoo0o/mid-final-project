<?php
  include './error.php';
  require_once './db.php';

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // echo 'From User Data: User Id Is: ' . $user_id . '<br>';
    
      $stmt = $conn->prepare('SELECT * FROM users WHERE user_id = ?');
      $stmt->execute([$user_id]);
      $user = $stmt->fetch();
  }