<?php
// db.php - Database connection and initialization

$db_file = __DIR__ . '/users.sqlite';
$dsn = 'sqlite:' . $db_file;

try {
    $pdo = new PDO($dsn);
    // Set errormode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Create the users table if it doesn't exist
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($createTableQuery);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
