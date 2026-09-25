<?php
session_start();
require 'db.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($username === "" || $password === "") {
        $error = "Username and password are required!";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM Users WHERE username = :username");
        $stmt->execute(['username' => $username]);

        if ($stmt->fetch()) {
            $error = "That username is already taken!";
        } else {
            // Create the new account with the regular "user" role
            $insert = $pdo->prepare("INSERT INTO Users (username, password, role) VALUES (:username, :password, 'user')");
            $insert->execute([
                'username' => $username,
                'password' => $password
            ]);

            $success = "Account created! You may now log in.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
   <div class="parent">
    <form method="POST">
       <h2>Create Account</h2>

        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="error" style="color:#9fd97a; border-color: rgba(159,217,122,0.3);"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if (!$success): ?>
            <label>Username:</label><br>
            <input type="text" name="username" required><br><br>
            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>
            <label>Confirm Password:</label><br>
            <input type="password" name="confirm_password" required><br><br>
            <button type="submit">Register</button>
            <p style="margin-top:18px; font-size:11px; letter-spacing:1px;">
                <a href="login.php" style="color:#a89568; text-decoration:none;">&larr; Back to Login</a>
            </p>
        <?php endif; ?>
    </form>

    <?php if ($success): ?>
        <div style="position:relative; z-index:1; text-align:center; padding-bottom:36px;">
            <a href="login.php" style="display:inline-block; padding:11px 28px; background:linear-gradient(180deg,#2a2015,#14100a); border:1px solid #d4af37; color:#e8d9a8; font-family:'Cinzel Decorative',serif; font-size:12px; letter-spacing:2px; text-transform:uppercase; text-decoration:none;">&larr; Back to Login</a>
        </div>
    <?php endif; ?>
   </div>

</body>
</html>
