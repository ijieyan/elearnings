<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SHS Guidance System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, <?php echo $role; ?>!</h1>
        <nav>
            <ul>
                <li><a href="view_students.php">View Students</a></li>
                <li><a href="add_record.php">Add Guidance Record</a></li>
                <?php if ($role == 'admin') { ?>
                    <li><a href="manage_users.php">Manage Users</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</body>
</html>

