<?php
require 'log_activity.php';
logActivity('About Us');

$videoSrc = "aboutv.mp4"; // different video only for About page
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Include the correct navbar based on role
if ($_SESSION['role'] === 'admin') {
    include 'navbar.php';   // admin navbar
} elseif ($_SESSION['role'] === 'user') {
    include 'navbar2.php';  // user navbar
} else {
    // Optional: unknown role, redirect to login
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
  <div class="card shadow">
    <img src="logo.webp" class="card-img-top cardheight:15rem;t:" alt="">
    <div class="card-body">
      <h3 class="card-title text-primary">Group Members Name and Their information</h3>
       <h7>Our team is strong, dedicated, and hardworking. 
        All members contribute equally to every task and work together cooperatively. 
        For this project, our E-Library website allows users to read any book they need online. 
        The team not only completes the assigned project based on what they have learned, but also practices together to improve their creativity and skills.
        Our website is still ongoing, and we plan to add more features in the future. 
        We sincerely thank you for following and supporting us!</h7>
      <h5 class="  mb-1">1, Abdi Sefu  Id No: Rcs/652/22</h5>
      <h5 class=" mb-1">2, Bezawit Hailu Id No: Rcs/026/22</h5>
      <h5 class="  mb-1">3, Bezawit Getachew Teshome Id No: Rcs/027/22</h5>
      <h5 class="  mb-1">4, Bezawit Getachew Tafera  Id No: Rcs/028/22</h5>
      <h5 class="  mb-1">5, Etsegent Girma Id No: Rcs/053/22</h5>

      <div class="text-end mt-4">
        <p class="text-secondary mb-1"><strong>Submitted to: Mr. Sileshi W </strong></p>
        <p class="text-secondary"><strong>Date:</strong> 2025-12-11</p>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
