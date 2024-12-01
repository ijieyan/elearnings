<aside>
    <ul>
        <li><a href="view_students.php">View Students</a></li>
        <li><a href="add_record.php">Add Record</a></li>
        <?php if ($_SESSION['role'] == 'admin') { ?>
            <li><a href="manage_users.php">Manage Users</a></li>
        <?php } ?>
    </ul>
</aside>
