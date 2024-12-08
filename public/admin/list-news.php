<?php
require_once '../../app/db.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$db = connectMongoDB();
$collection = $db->NewsOne;
if (isset($_GET['delete'])) {
    $newsId = $_GET['delete'];

    if (preg_match('/^[a-f0-9]{24}$/', $newsId)) {
        $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($newsId)]);
        header("Location: list-news.php");
        exit;
    } else {
        echo "Invalid ObjectId format.";
    }
}

$newsList = $collection->find();

$newsArray = iterator_to_array($newsList);
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
            <div class="d-flex justify-content-end mb-4">
                <a href="create.php"><button type="button" class="btn btn-dark">Create some news</button></a>
            </div>

            <div class="container">
                <?php
                include '../partials/table.php';
                ?>
            </div>
        </div>
    </div>
</body>