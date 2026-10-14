<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM posts WHERE id = $id";

    if ($conn->query($sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error deleting post.";
    }
}
?>