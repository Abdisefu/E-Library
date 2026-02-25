<?php
include 'db.php';
$search = "";
$results = [];

if (isset($_POST['search_book'])) {
    $search = $conn->real_escape_string($_POST['search']);

    // First try to find exact matches
    $exact_sql = "SELECT * FROM books WHERE title = '$search'";
    $exact_query = $conn->query($exact_sql);

    if ($exact_query->num_rows > 0) {
        while ($row = $exact_query->fetch_assoc()) {
            $results[] = $row;
        }
    } else {
        // No exact match, fetch relevant partial matches
        $partial_sql = "
            SELECT *,
            (
                (title LIKE '$search%') * 50 +    
                (title LIKE '%$search%') * 20 +   
                (author LIKE '%$search%') * 10 +  
                (isbn LIKE '%$search%') * 5       
            ) AS relevance
            FROM books
            WHERE title LIKE '%$search%' 
               OR author LIKE '%$search%' 
               OR isbn LIKE '%$search%'
            ORDER BY relevance DESC, title ASC
        ";
        $partial_query = $conn->query($partial_sql);
        if ($partial_query->num_rows > 0) {
            while ($row = $partial_query->fetch_assoc()) {
                $results[] = $row;
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Retrieve Books</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Retrieve Books</h2>
    
    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Enter title, author, or ISBN" value="<?php echo htmlspecialchars($search); ?>" required>
            <button type="submit" name="search_book" class="btn btn-primary">Retrieve</button>
        </div>
    </form>

    <?php if(isset($_POST['search_book'])): ?>
        <?php if(count($results) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Published Year</th>
                        <th>Available</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($results as $book): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                        <td><?php echo htmlspecialchars($book['published_year']); ?></td>
                        <td><?php echo $book['available'] ? 'Yes' : 'No'; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-danger">No books found matching "<?php echo htmlspecialchars($search); ?>"</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
