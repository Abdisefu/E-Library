<?php
include 'db.php';
$message = "";

// Process form submission
if (isset($_POST['add_book'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $published_year = $conn->real_escape_string($_POST['published_year']);
    $available = isset($_POST['available']) ? 1 : 0;

    // Handle file upload
   $file_path = NULL;

if (isset($_FILES['book_file'])) {

    // Handle PHP upload errors first
    switch ($_FILES['book_file']['error']) {
        case UPLOAD_ERR_OK:
            // Good, no error
            break;

        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $message = "<p class='text-danger'>File is too large! Increase upload_max_filesize and post_max_size.</p>";
            return;

        case UPLOAD_ERR_NO_FILE:
            // No file selected (optional)
            break;

        default:
            $message = "<p class='text-danger'>Upload error occurred! Error code: " . $_FILES['book_file']['error'] . "</p>";
            return;
    }

    // OPTIONAL: restrict allowed file types
    $allowed_extensions = ['pdf', 'epub', 'txt'];
    $ext = strtolower(pathinfo($_FILES['book_file']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_extensions)) {
        $message = "<p class='text-danger'>Invalid file type! Allowed: PDF, EPUB, TXT.</p>";
        return;
    }

    // Upload handling
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = basename($_FILES['book_file']['name']);
    $target_file = $upload_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES['book_file']['tmp_name'], $target_file)) {
        $file_path = $target_file;
    } else {
        $message = "<p class='text-danger'>Error saving uploaded file!</p>";
    }
}


    // Insert into database
    $sql = "INSERT INTO books (title, author, isbn, published_year, available, file_path)
            VALUES ('$title', '$author', '$isbn', '$published_year', '$available', '$file_path')";

    if ($conn->query($sql) === TRUE) {
        $message = "<p class='text-success'>Book added successfully!</p>";
    } else {
        $message = "<p class='text-danger'>Error: " . $conn->error . "</p>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Book to shelf</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


    <?php include 'navbar.php'; ?> 
    <div class="row">
<div class="card" style="width: 40rem; ">
  <div class="card-body">
<div class="container bg-info">
    <h2>Add New Book</h2>
    <?php if ($message != "") echo $message; ?>

    <form method="POST" enctype="multipart/form-data"> <!-- enctype is required for file uploads -->
        <div class="row">
            <div class="col">
                <label>Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="col">
                <label>Author</label>
                <input type="text" class="form-control" name="author" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <label>ISBN</label>
                <input type="text" class="form-control" name="isbn" required>
            </div>
            <div class="col">
                <label>Published Year</label>
                <input type="number" class="form-control" name="published_year" placeholder="YYYY">
            </div>
        </div>

        <div class="mb-3 form-check mt-3">
            <input type="checkbox" class="form-check-input" name="available" checked>
            <label class="form-check-label">Available</label>
        </div>

        <div class="mb-3">
            <label>Upload Book File</label>
            <input type="file" class="form-control" name="book_file">
        </div>

        <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
    </form>
</div>

  </div>
  
</div>
<div class="col">
 <div class="card" style="width: 44rem;">
  <img src="empty shelf.webp" class="card-img-top" alt="...">
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
