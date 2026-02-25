<?php
include 'db.php'; // Database connection

$message = "";

// Process deletion when form is submitted
if (isset($_POST['delete_book'])) {
    $title = $conn->real_escape_string($_POST['title']);

    // Delete book(s) with this title
    $sql = "DELETE FROM books WHERE title='$title'";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            $message = "<p class='text-success'>Book(s) with title '{$title}' deleted successfully!</p>";
        } else {
            $message = "<p class='text-warning'>No book found with title '{$title}'.</p>";
        }
    } else {
        $message = "<p class='text-danger'>Error deleting book: " . $conn->error . "</p>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Delete Book</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<!-- Include Navbar -->
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Delete Book From the List</h2>
    
    <?php if ($message != "") echo $message; ?>
    
    <form id="deleteForm" method="POST">
        <div class="mb-3">
            <label class="form-label">Book Title</label>
            <input type="text" class="form-control" name="title" placeholder="Enter book title to delete" required>
        </div>
        <input type="hidden" name="delete_book" value="1">
        <button type="button" class="btn btn-danger bi bi-trash-fill" data-bs-toggle="modal" data-bs-target="#confirmModal">
            Delete
        </button>
    </form>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="confirmModalLabel">Confirm Deletion</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this book permanently?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="submitDelete()">Yes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
function submitDelete() {
    document.getElementById('deleteForm').submit();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
