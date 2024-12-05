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

// Handle delete request
if (isset($_GET['delete'])) {
    $newsId = $_GET['delete'];

    // Validate if the ObjectId is a valid 24-character hex string
    if (preg_match('/^[a-f0-9]{24}$/', $newsId)) {
        // Delete news from the MongoDB collection
        $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($newsId)]);
        header("Location: list-news.php"); // Redirect after deletion
        exit;
    } else {
        echo "Invalid ObjectId format.";
    }
}

// Fetch all news from the NewsOne collection
$newsList = $collection->find();

// Convert the result to an array
$newsArray = iterator_to_array($newsList);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of News</title>
</head>

<body>
    <h1>News List</h1>

    <nav>
        <a href="create.php">Create News</a>
        <a href="logout.php">Logout</a>
    </nav>

    <?php if (empty($newsArray)): ?>
        <p>No news found.</p>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Published Date</th>
                    <th>Action</th> <!-- New Action Column -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($newsArray as $news): ?>
                    <tr>
                        <td><?= htmlspecialchars($news['title']) ?></td>
                        <td><?= htmlspecialchars($news['content']) ?></td>
                        <td><?= htmlspecialchars($news['author']) ?></td>
                        <td>
                            <?php
                            // Check if created_at is a DateTime or ISODate
                            if (isset($news['created_at'])) {
                                if ($news['created_at'] instanceof MongoDB\BSON\UTCDateTime) {
                                    // If it's a MongoDB DateTime object
                                    $date = $news['created_at']->toDateTime();
                                    echo $date->format('Y-m-d H:i:s');
                                } elseif (is_numeric($news['created_at'])) {
                                    // If it's a timestamp in milliseconds
                                    $date = new DateTime();
                                    $date->setTimestamp($news['created_at'] / 1000); // Convert milliseconds to seconds
                                    echo $date->format('Y-m-d H:i:s');
                                } else {
                                    echo "Invalid Date Format";
                                }
                            } else {
                                echo "Date Not Set";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="?delete=<?= $news['_id'] ?>" onclick="return confirm('Are you sure you want to delete this news?')">Delete</a>
                            <a href="edit.php?id=<?= $news['_id'] ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>

</html>