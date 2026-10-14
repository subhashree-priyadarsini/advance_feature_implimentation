<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

/* Search */
$search = isset($_GET['search']) ? $_GET['search'] : '';

/* Pagination */
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

/* Count total matching posts */
$countQuery = "SELECT COUNT(*) AS total
               FROM posts
               WHERE title LIKE '%$search%'
               OR content LIKE '%$search%'";

$countResult = $conn->query($countQuery);
$totalPosts = $countResult->fetch_assoc()['total'];
$totalPages = max(1, ceil($totalPosts / $limit));

/* Fetch posts */
$query = "SELECT *
          FROM posts
          WHERE title LIKE '%$search%'
          OR content LIKE '%$search%'
          ORDER BY created_at DESC
          LIMIT $limit OFFSET $offset";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>

<p>
    <a href="add_post.php">Add New Post</a> |
    <a href="logout.php">Logout</a>
</p>

<hr>

<h3>All Posts</h3>

<!-- Search Form -->
<form method="GET">
    <input
        type="text"
        name="search"
        placeholder="Search by title or content"
        value="<?php echo htmlspecialchars($search); ?>"
    >
    <button type="submit">Search</button>
</form>

<br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>

        <td>
            <?php echo htmlspecialchars($row['title']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['content']); ?>
        </td>

        <td><?php echo $row['created_at']; ?></td>

        <td>
            <a href="edit_post.php?id=<?php echo $row['id']; ?>">
                Edit
            </a>
            |
            <a href="delete_post.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Are you sure you want to delete this post?');">
                Delete
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

<br>

<!-- Pagination -->
<div class="pagination">
    <?php for($i = 1; $i <= $totalPages; $i++) { ?>
    <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
       style="<?php echo ($page == $i) ? 'background: #0056b3;' : ''; ?>">
        <?php echo $i; ?>
    </a>
<?php } ?>
</div>

</body>
</html>