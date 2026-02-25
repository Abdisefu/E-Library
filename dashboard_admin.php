<?php
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Home page</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center mt-5">
  <div class= "row">
    <div class="col">
        
    <div class="card bg-success p-2" style="width: 69.5rem; height:13rem; bg-success">
  <div class="card-body">
    <h1>Hello <?php echo htmlspecialchars($_SESSION['firstname']); ?> Admin!</h1>
     <div class="text-warning"> <h5>Don't forget!    Manage your E-library system carefully from those all unauthorized Users.</h5> </div>
    <h5> please click on Next to Access more....... </h5>
   
    <!-- OK button redirects to navbar page -->
    <a href="navbar.php" class="btn btn-primary px-4">Next</a>

    <!-- Logout -->
    <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</div>
</div>

<div class="row">

<div class="col">
    <div class="card" style="width: 35rem;height:20rem;">
  <img src="shelf4.webp" class="card-img-top" alt="...">
</div>
</div>


  <div class="col">
    <div class="card" style="width: 33rem;height:25rem;">
  <img src="shelf.webp" class="card-img-top" alt="...">
</div>  
</div>
</div>
<div class="row">
<div class="col">
    <div class="card" style="width: 35rem;height:20rem;">
  <img src="shelf7.jpg" class="card-img-top" alt="...">
</div> 
</div>
<div class="col">
    <div class="card" style="width: 33rem;height:20rem;">
  <img src="shelf7.jpg" class="card-img-top" alt="...">
</div> 
</div>

</div>
</div>
</body>
</html>
