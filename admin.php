<?php
session_start();
require 'db.php';

// Security Guard: Check for wristband AND admin status
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied. You must be an administrator.");
}

// Fetch every account — users and admins — for the table below
$stmt = $pdo->query("SELECT id, username, role FROM Users ORDER BY username ASC");
$allAccounts = $stmt->fetchAll();

// Split into two lists so admins and users can sit in their own columns
$admins = array_values(array_filter($allAccounts, fn($a) => $a['role'] === 'admin'));
$users  = array_values(array_filter($allAccounts, fn($a) => $a['role'] !== 'admin'));
$rowCount = max(count($admins), count($users));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="dashboard-body">

    <!-- Top Navigation Bar (Admin Theme) -->
    <header class="navbar navbar-admin">
        <div class="nav-brand">
            Admin Panel <span class="badge-admin">Admin</span>
        </div>
        <div>
            <a href="register_admin.php" class="btn-logout" style="margin-right:12px;">Create Admin</a>
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="dashboard-container">
        <div class="welcome-card admin-card">
            <h1>Welcome to the Admin Area, <span><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>!</h1>
            <p>You have full administrative privileges to manage system settings and users.</p>
        </div>

        <div class="users-table-card">
            <h2>All Accounts</h2>
            <div class="table-scroll">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th class="col-admin">Admins</th>
                            <th class="col-user">Users</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($rowCount > 0): ?>
                            <?php for ($i = 0; $i < $rowCount; $i++): ?>
                                <tr>
                                    <td>
                                        <?php if (isset($admins[$i])): ?>
                                            <?php echo htmlspecialchars($admins[$i]['username']); ?>
                                        <?php else: ?>
                                            <span class="empty-cell">&mdash;</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (isset($users[$i])): ?>
                                            <?php echo htmlspecialchars($users[$i]['username']); ?>
                                        <?php else: ?>
                                            <span class="empty-cell">&mdash;</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="empty-cell" style="text-align:center;">No accounts found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>