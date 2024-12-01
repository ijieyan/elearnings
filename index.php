<?php
// Redirect to login page if the user is not logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location:login.php");
    exit();
}
?>