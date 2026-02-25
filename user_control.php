<?php
session_start();
require 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['email']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit;
}

/* USER ACTIONS */
if (isset($_GET['block'])) {
    $id = intval($_GET['block']);
    $stmt = $conn->prepare("UPDATE users SET status='blocked' WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if (isset($_GET['unblock'])) {
    $id = intval($_GET['unblock']);
    $stmt = $conn->prepare("UPDATE users SET status='active' WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");

// Fetch file access logs (using your exact columns)
$logs = $conn->query("
    SELECT id, username, email, file_name, title, access_time
    FROM file_access_log
    ORDER BY access_time DESC
");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User Control - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container bg-success bg-opacity-75 py-4">

    <h2 class="mb-4">Admin Control Panel</h2>

    <!-- Buttons Row -->
    <table class="table mb-4">
        <tbody>
            <tr>
                <td class="text-center" style="border:none;">
                    <!-- Show Users Table -->
                    <button class="btn btn-secondary btn-sm me-2" type="button" data-bs-toggle="collapse" data-bs-target="#usersTable" aria-expanded="false" aria-controls="usersTable">
                        <i class="bi bi-gear-fill"></i> Control User
                    </button>

                    <!-- Show File Access Logs -->
                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#fileLogs" aria-expanded="false" aria-controls="fileLogs">
                        <i class="bi bi-folder-symlink"></i> View History
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- USERS TABLE (COLLAPSIBLE) -->
    <div class="collapse" id="usersTable">
        <h3 class="mb-3">Users</h3>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-danger">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if($users->num_rows > 0): ?>
                    <?php while($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['firstname']) ?></td>
                        <td><?= htmlspecialchars($row['lastname']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td>
                            <?php if($row['status'] === 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Blocked</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['status'] === 'active'): ?>
                                <a href="user_control.php?block=<?= $row['id'] ?>" class="btn btn-warning btn-sm mb-1" onclick="return confirm('Block this user?')">
                                    <i class="bi bi-lock-fill"></i> Block
                                </a>
                            <?php else: ?>
                                <a href="user_control.php?unblock=<?= $row['id'] ?>" class="btn btn-success btn-sm mb-1" onclick="return confirm('Unblock this user?')">
                                    <i class="bi bi-unlock-fill"></i> Unblock
                                </a>
                            <?php endif; ?>
                            <a href="user_control.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Delete this user?')">
                                <i class="bi bi-trash-fill"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- FILE ACCESS LOGS TABLE (COLLAPSIBLE) -->
    <div class="collapse" id="fileLogs">
        <h3 class="mb-3 mt-4">File Access Logs</h3>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-danger">
                <tr>
                    <th>Log ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>File Name</th>
                    <th>Book Title</th>
                    <th>Accessed Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if($logs->num_rows > 0): ?>
                    <?php while($log = $logs->fetch_assoc()): ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><?= htmlspecialchars($log['username']) ?></td>
                        <td><?= htmlspecialchars($log['email']) ?></td>
                        <td><?= htmlspecialchars($log['file_name']) ?></td>
                        <td><?= htmlspecialchars($log['title']) ?></td>
                        <td><?= date('Y-m-d', strtotime($log['access_time'])) ?></td>
                        <td><?= date('H:i:s', strtotime($log['access_time'])) ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No file access logs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
