<?php

// include_once './error.php';

  if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    http_response_code(403);
    header('Location: ./accessDenied.html');
    exit();
  }

  $dsn = "mysql:host=127.0.0.1; dbname=worknest_db";
  $username = 'root';
  $password = 'Vigo0@mysql';


  try {
    $conn = new PDO($dsn, $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; 
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}