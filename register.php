<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(username,password)
            VALUES('$username','$password')";

    if ($conn->query($sql)) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>User Registration</h2>

<form method="POST">
    Username:
    <input type="text" name="username" required><br><br>

    Password:
    <input type="password" name="password" required><br><br>

    <button type="submit">Register</button>
</form>

<p><?php echo $message; ?></p>

login.phpLogin Here</a>

</body>
</html>