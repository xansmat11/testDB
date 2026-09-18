<?php
session_start(); // <--- MUST be the very first line of execution

// Security Check: Redirect if not logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="dashboard-body">

    <!-- Top Navigation Bar -->
    <header class="navbar">
        <div class="nav-brand">Dashboard</div>
        <a href="logout.php" class="btn-logout">Log Out</a>
    </header>

    <!-- Main Content Card -->
    <main class="dashboard-container">
        <div class="welcome-card">
            <h1>Welcome, <span><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>!</h1>
            <p>You have successfully logged into your account.</p>
        </div>
    </main>

</body>
</html>