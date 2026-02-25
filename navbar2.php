<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// USER only
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Library</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">E-Library system</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item"><a class="nav-link active" href="about.php"><i class="bi bi-info-circle-fill"></i> About Us</a></li>
        <li class="nav-item"><a class="nav-link active" href="read.php"><i class="bi bi-book"></i> Read</a></li>
        <li class="nav-item"><a class="nav-link active" href="search.php"><i class="bi bi-search"></i> Search</a></li>

      </ul>
    </div>
  </div>
</nav>

<video autoplay muted loop playsinline style="width:100%; height:400px; object-fit:cover; display:block;">
    <source src="aboutv.mp4" type="video/mp4">
</video>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
