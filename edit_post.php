<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    die("No post selected.");
}

$id = $_GET['id'];

if(isset($_POST['update'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts
            SET title='$title',
                content='$content'
            WHERE id=$id";

    $conn->query($sql);

    header("Location: dashboard.php");
}

$result = $conn->query("SELECT * FROM posts WHERE id=$id");
$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Post</h2>

<form method="POST">

Title:<br>
<input type="text"
       name="title"
       value="<?php echo $post['title']; ?>"
       required>

<br><br>

Content:<br>

<textarea name="content"
          rows="5"
          cols="40"
          required><?php echo $post['content']; ?></textarea>

<br><br>

<button type="submit" name="update">
    Update Post
</button>

</form>

</body>
</html>