<?php
session_start();

// USER access ONLY
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header("Location: login_user.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center mt-5">
  <div class="row">
    <div class="col">
      <div class="card bg-info " style="width: 69.5rem; height:13rem;">
        <div class="card-body">
          <h1>Welcome our costemer Mr. <?php echo htmlspecialchars($_SESSION['firstname']); ?>! to our E-Library system.</h1>

          <!-- OK button redirects to navbar2 page for users -->
          <a href="navbar2.php" class="btn btn-primary px-4 ms-5 mt-5">Ok</a>

          <!-- Logout -->
          <a href="logout.php" class="btn btn-danger mt-5">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="card" style="width: 35rem; height:20rem;">
        <img src="shelf4.webp" class="card-img-top" alt="...">
      </div>
    </div>

    <div class="col">
      <div class="card" style="width: 33rem; height:25rem;">
        <img src="shelf.webp" class="card-img-top" alt="...">
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="card" style="width: 35rem; height:20rem;">
        <img src="shelf7.jpg" class="card-img-top" alt="...">
      </div>
    </div>

    <div class="col">
      <div class="card" style="width: 33rem; height:20rem;">
        <img src="shelf7.jpg" class="card-img-top" alt="...">
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
