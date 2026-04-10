<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
include '../includes/db.php';

$id = $_GET['id'];
$action = $_GET['action'];

if ($action == 'approve') {
    $req = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin_requests WHERE id=$id"));
    mysqli_query($conn, "INSERT INTO users (name, email, password, role) 
    VALUES ('{$req['name']}','{$req['email']}','{$req['password']}','admin')");
    mysqli_query($conn, "UPDATE admin_requests SET status='approved' WHERE id=$id");
} else {
    mysqli_query($conn, "UPDATE admin_requests SET status='rejected' WHERE id=$id");
}

header('Location: dashboard.php');
?>