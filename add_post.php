<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts(title, content)
            VALUES('$title', '$content')";

    if ($conn->query($sql)) {
        $message = "Post added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Add New Post</h2>

<form method="POST">

Title:<br>
<input type="text" name="title" required>
<br><br>

Content:<br>
<textarea name="content" rows="5" cols="40" required></textarea>
<br><br>

<button type="submit">Add Post</button>

</form>

<p><?php echo $message; ?></p>

<br>

dashboard.phpBack to Dashboard</a>

</body>
</html>