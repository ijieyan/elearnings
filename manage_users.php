<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: dashboard.php');
    exit;
}

include('config/db_config.php');
include('includes/header.php');
include('includes/sidebar.php');

$stmt = $pdo->prepare('SELECT * FROM users');
$stmt->execute();
$users = $stmt->fetchAll();
?>

<div class="dashboard">
    <h1>Manage Users</h1>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td><a href="#">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
