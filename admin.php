<?php
session_start();

// Security Guard: Check for wristband AND admin status
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied. You must be an administrator.");
}
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
        <a href="logout.php" class="btn-logout">Log Out</a>
    </header>

    <!-- Main Content Area -->
    <main class="dashboard-container">
        <div class="welcome-card admin-card">
            <h1>Welcome to the Admin Area, <span><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>!</h1>
            <p>You have full administrative privileges to manage system settings and users.</p>
        </div>
    </main>

</body>
</html>