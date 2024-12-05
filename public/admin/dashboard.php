<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
</head>

<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['admin']) ?></h1>
    <nav>
        <a href="create.php">Create News</a>
        <a href="list-news.php">List</a>
        <a href="logout.php">Logout</a>
    </nav>
</body>

</html>