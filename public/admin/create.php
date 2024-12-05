<?php
require_once '../../app/db.php'; 

use MongoDB\BSON\UTCDateTime;

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = connectMongoDB();
    $collection = $db->NewsOne; 

    // Get form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $summary = $_POST['summary'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $image = $_POST['image'];

    $document = [
        'title' => $title,
        'content' => $content,
        'summary' => $summary,
        'category' => $category,
        'author' => $author,
        'image' => $image,
        'created_at' => new MongoDB\BSON\UTCDateTime(),
        'updated_at' => new MongoDB\BSON\UTCDateTime()
    ];

    // Insert the document into the collection
    $result = $collection->insertOne($document);

    // Check if the insert was successful
    if ($result->getInsertedCount() > 0) {
        header("Location: list-news.php"); // Redirect to the news list page
        exit;
    } else {
        $error = "Failed to add news.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create News</title>
</head>

<body>
    <h1>Create News</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="content">Content</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>

        <label for="summary">Summary</label>
        <input type="text" id="summary" name="summary" required><br><br>

        <label for="category">Category</label>
        <input type="text" id="category" name="category" required><br><br>

        <label for="author">Author</label>
        <input type="text" id="author" name="author" required><br><br>

        <label for="image">Image URL</label>
        <input type="text" id="image" name="image" required><br><br>

        <button type="submit">Create</button>
    </form>
</body>

</html>