<?php
include_once '../db.php';
include_once '../error.php';
session_start();

$companyId = $_SESSION['company_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobTitle = $_POST['jobTitle'];
    $jobLocation = $_POST['jobLocation'];
    $employmentType = $_POST['employmentType'];
    $salaryRange = $_POST['salaryRange'] ?? '';
    $jobCategory = $_POST['jobCategory'];
    $jobDescription = $_POST['jobDescription'];
    $jobRequerment = $_POST['jobRequerment'];
    $receiveApplicationMethod = $_POST['receiveApplicationMethod'];
    $applicationEmail = $_POST['appEmail'];

    // echo $jobTitle . '<br>';
    // echo $jobLocation . '<br>';
    // echo $employmentType . '<br>';
    // echo $salaryRange . '<br>';
    // echo $jobDescription . '<br>';
    // echo $jobRequerment . '<br>';
    // echo $receiveApplicationMethod . '<br>';
    // echo $applicationEmail . '<br>';


    $stmt = $conn->prepare("
        INSERT INTO jobs (
            title, 
            location, 
            employment_type, 
            salary,
            category_id,
            description, 
            requirements, 
            receive_application_method, 
            receive_application_email,
            company_id
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $parameters = [
        $jobTitle, 
        $jobLocation, 
        $employmentType, 
        $salaryRange, 
        $jobCategory, 
        $jobDescription, 
        $jobRequerment, 
        $receiveApplicationMethod, 
        $applicationEmail,
        $companyId
    ];

    if ($stmt->execute($parameters)) {
      header('Location: ../companyProfile.php?jobPost=done');
      exit;
    }
} 