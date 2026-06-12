<?php
session_start();
require_once 'db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $error = "Username is already taken.";
        } else {
            // Hash password and insert
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            
            try {
                $stmt->execute([$username, $hashedPassword]);
                $success = "Registration successful! You can now <a href='login.php' style='color: white; text-decoration: underline;'>login</a>.";
            } catch (PDOException $e) {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Premium Auth</title>
    <meta name="description" content="Create a new account">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Create Account</h1>
            <p>Join our secure platform today</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php else: ?>
            <form method="POST" action="register.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required autocomplete="username">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a strong password" required autocomplete="new-password">
                </div>
                
                <button type="submit" class="btn">Sign Up</button>
            </form>
        <?php endif; ?>
        
        <div class="footer-text">
            Already have an account? <a href="login.php">Log In</a>
        </div>
    </div>
</body>
</html>
