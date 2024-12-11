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

<?php
include '../partials/cdn.php';
?>
<title>Dashboard</title>

<body>
    <?php
    include '../partials/navbar.php';
    ?>
    <div class="d-flex">

        <?php
        include '../partials/sidebar.php';
        ?>

        <div class="flex-grow-1 p-4">
            <p class="text-muted">Let's share the latest update, Admin!</p>
            <form action="" method="POST">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-2">Title</div>
                        <div class="col-10">
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">Content</div>
                        <div class="col-10">
                            <textarea type="text" class="form-control" id="content" name="content" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">Summary</div>
                        <div class="col-10">
                            <input type="text" class="form-control" id="summary" name="summary" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">Category</div>
                        <div class="col-10">
                            <select class="form-control" id="category" name="category" required>
                                <option value="teknologi">Teknologi</option>
                                <option value="politik">Politik</option>
                                <option value="olahraga">Olahraga</option>
                                <option value="kesehatan">Kesehatan</option>
                                <option value="hiburan">Hiburan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">Author</div>
                        <div class="col-10">
                            <input type="text" class="form-control" id="author" name="author" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">Image URL</div>
                        <div class="col-10">
                            <input type="text" class="form-control" id="image" name="image" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <button type="submit" class="btn btn-dark">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>