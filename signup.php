<?php
session_start();
include('config/db_config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; // Default role can be 'user' or 'admin', depending on your setup

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error = 'Username is already taken.';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
            $stmt->execute([$username, $hashed_password, $role]);

            // Redirect to login page after successful registration
            header('Location: login.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - SHS Guidance System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <form method="POST" action="">
            <h2>Signup</h2>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Sign Up</button>

            <?php if (isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>
            <p>Already have an account? <a href="login.php">Login here</a></p>

        </form>
    </div>
</body>
</html>
