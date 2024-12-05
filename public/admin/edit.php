<?php
require_once '../../app/db.php'; // Include database connection

// Start session to check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Connect to MongoDB
$db = connectMongoDB();
$collection = $db->NewsOne; // Name of the collection

// Handle Edit Request
if (isset($_GET['id'])) {
    $newsId = $_GET['id'];

    // Validate if the ObjectId is a valid 24-character hex string
    if (preg_match('/^[a-f0-9]{24}$/', $newsId)) {
        // Fetch the news item from the MongoDB collection
        $news = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($newsId)]);
    } else {
        echo "Invalid ObjectId format.";
        exit;
    }
}

// Handle Update Request
if (isset($_POST['update'])) {
    // Collect new data from the form
    $updatedNews = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'author' => $_POST['author'],
        'summary' => $_POST['summary'], // New summary field
    ];

    // Handle image link input
    if (!empty($_POST['image_url'])) {
        $updatedNews['image'] = $_POST['image_url']; // Save the image URL
    }

    // Update the news item in the MongoDB collection
    $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($newsId)],
        ['$set' => $updatedNews]
    );

    // Redirect back to the list-news page after update
    header("Location: list-news.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News</title>
</head>

<body>
    <h1>Edit News</h1>

    <nav>
        <a href="list-news.php">Back to News List</a>
    </nav>

    <?php if (isset($news)): ?>
        <form method="POST">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($news['title']) ?>" required><br><br>

            <label for="content">Content:</label><br>
            <textarea id="content" name="content" rows="4" required><?= htmlspecialchars($news['content']) ?></textarea><br><br>

            <label for="author">Author:</label><br>
            <input type="text" id="author" name="author" value="<?= htmlspecialchars($news['author']) ?>" required><br><br>

            <label for="summary">Summary:</label><br>
            <textarea id="summary" name="summary" rows="3" required><?= htmlspecialchars($news['summary']) ?></textarea><br><br>

            <label for="image_url">Image URL:</label><br>
            <input type="text" id="image_url" name="image_url" value="<?= htmlspecialchars($news['image'] ?? '') ?>"><br><br>

            <?php if (!empty($news['image'])): ?>
                <img src="<?= htmlspecialchars($news['image']) ?>" alt="Current Image" width="100"><br><br>
            <?php endif; ?>

            <input type="submit" name="update" value="Update News">
        </form>
    <?php else: ?>
        <p>News not found.</p>
    <?php endif; ?>

</body>

</html>