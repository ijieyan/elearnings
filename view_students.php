<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('config/db_config.php');
include('includes/header.php');
include('includes/sidebar.php');

$stmt = $pdo->prepare('SELECT * FROM students');
$stmt->execute();
$students = $stmt->fetchAll();
?>

<div class="dashboard">
    <h1>Student List</h1>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Grade Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo $student['student_id']; ?></td>
                <td><?php echo $student['student_name']; ?></td>
                <td><?php echo $student['grade_level']; ?></td>
                <td><a href="#">View Details</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
