<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home page</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container text-center mt-5">

    <div class="row">
        <div class="col">

            <div class="card bg-info" style="width: 42rem; height: 17rem;">
                <div class="card-body">
                    <h1>Welcome to E-Library</h1>
                    <p>Please select your role to login into the system:</p>

                    <div class="d-flex justify-content-center gap-3 mt-4">

                        <!-- ADMIN BUTTON -->
                        <form action="login_admin.php" method="get">
                            <button type="submit" class="btn btn-primary btn-lg">I am Admin</button>
                        </form>

                        <!-- USER BUTTON -->
                        <form action="login_user.php" method="get">
                            <button type="submit" class="btn btn-success btn-lg">I am User</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>

        <div class="col">
            <div class="card" style="width: 25rem;">
                <img src="navlab.webp" class="card-img-top" alt="E-Library Image">
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <video autoplay muted loop playsinline style="width:100%; height:350px; object-fit:cover; display:block;">
            <source src="labvideo.mp4" type="video/mp4">
        </video>
    </div>

</div>

</body>
</html>
