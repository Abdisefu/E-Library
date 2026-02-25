<?php
include 'db.php'; // Database connection

$message = "";
$book = null;

// Step 1: Handle search by title
if (isset($_POST['search_book'])) {
    $title_search = $conn->real_escape_string($_POST['title_search']);

    // Search for book by exact title
    $query = "SELECT * FROM books WHERE title='$title_search' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $book = $result->fetch_assoc();
    } else {
        $message = "<p class='text-danger'>Book not found.</p>";
    }
}

// Step 2: Handle update submission
if (isset($_POST['update_book'])) {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $published_year = $conn->real_escape_string($_POST['published_year']);
    $available = isset($_POST['available']) ? 1 : 0;

    $update_sql = "
        UPDATE books SET
            title='$title',
            author='$author',
            isbn='$isbn',
            published_year='$published_year',
            available='$available'
        WHERE id=$id
    ";

    if ($conn->query($update_sql) === TRUE) {
        $message = "<p class='text-success'>Book updated successfully!</p>";

        // Reload updated book
        $result = $conn->query("SELECT * FROM books WHERE id=$id");
        $book = $result->fetch_assoc();
    } else {
        $message = "<p class='text-danger'>Error updating: " . $conn->error . "</p>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update Book</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5 bg-info">
    <h2> Update Book if Necessary</h2>

    <?php if ($message != "") echo $message; ?>

    <!-- Step 1: Search by Title -->
    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="title_search" placeholder="Enter book title" required>
            <button type="submit" name="search_book" class="btn btn-secondary">Search</button>
        </div>
    </form>

    <!-- Step 2: Update Form (only shown if book is found) -->
    <?php if ($book) { ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $book['id']; ?>">

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($book['title']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Author</label>
                <input type="text" class="form-control" name="author" value="<?= htmlspecialchars($book['author']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">ISBN</label>
                <input type="text" class="form-control" name="isbn" value="<?= htmlspecialchars($book['isbn']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Published Year</label>
                <input type="number" class="form-control" name="published_year" value="<?= htmlspecialchars($book['published_year']); ?>">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="available" <?= $book['available'] ? 'checked' : ''; ?>>
                <label class="form-check-label">Available</label>
            </div>

            <button type="submit" name="update_book" class="btn btn-primary">Update Book</button>
        </form>
    <?php } ?>
</div>

</body>
</html>
