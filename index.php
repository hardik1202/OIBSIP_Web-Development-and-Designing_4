<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
// Get the first letter for the avatar
$avatarLetter = strtoupper(substr($username, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Premium Auth</title>
    <meta name="description" content="Secured dashboard area">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container dashboard-container">
        <div class="dashboard-header">
            <div class="user-info">
                <div class="avatar"><?php echo htmlspecialchars($avatarLetter); ?></div>
                <div>
                    <h2>Hello, <?php echo htmlspecialchars($username); ?>!</h2>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Welcome to your secured area.</p>
                </div>
            </div>
            <a href="logout.php" class="btn btn-outline" style="width: auto; margin-top: 0;">Log Out</a>
        </div>
        
        <div class="dashboard-content">
            <h3>Confidential Data</h3>
            <br>
            <p>This page is completely secure. Only authenticated users with a valid session can view this content.</p>
            <br>
            <p>Your session is managed securely by PHP. The styling utilizes modern CSS techniques including glassmorphism, animated gradients, and custom properties to deliver a premium user experience.</p>
        </div>
    </div>
</body>
</html>
