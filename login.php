<?php
session_start();
require_once 'db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Fetch user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Success! Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Redirect to dashboard
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Premium Auth</title>
    <meta name="description" content="Sign in to your account">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome Back</h1>
            <p>Sign in to access your dashboard</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required autocomplete="username">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
            </div>
            
            <button type="submit" class="btn">Log In</button>
        </form>
        
        <div class="footer-text">
            Don't have an account? <a href="register.php">Sign Up</a>
        </div>
    </div>
</body>
</html>
