<?php
require_once '../../app/db.php';
include 'partials/header.php';

$db = connectMongoDB();

$newsId = $_GET['id'];

$news = $db->NewsOne->findOne(['_id' => new MongoDB\BSON\ObjectId($newsId)]);

?>

<div class="detail-news">
    <h1><?= htmlspecialchars($news['title']) ?></h1>
    <p><?= htmlspecialchars($news['content']) ?></p>
</div>

<?php include 'partials/footer.php'; ?>