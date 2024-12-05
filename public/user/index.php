<?php
require_once '../../app/db.php';

$db = connectMongoDB();
$collection = $db->NewsOne;

$newsList = $collection->find();

$newsArray = iterator_to_array($newsList);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Website</title>
</head>

<body>
    <h1>Latest News</h1>

    <nav>
        <a href="index.php">Home</a>
    </nav>

    <?php if (empty($newsArray)): ?>
        <p>No news found.</p>
    <?php else: ?>
        <div>
            <?php foreach ($newsArray as $news): ?>
                <div style="border: 1px solid #ddd; margin-bottom: 20px; padding: 10px;">
                    <h2><?= htmlspecialchars($news['title']) ?></h2>
                    <p><strong>Author:</strong> <?= htmlspecialchars($news['author']) ?></p>
                    <p><strong>Published Date:</strong>
                        <?php
                        if (isset($news['created_at'])) {
                            if ($news['created_at'] instanceof MongoDB\BSON\UTCDateTime) {
                                $date = $news['created_at']->toDateTime();
                                echo $date->format('Y-m-d H:i:s');
                            } elseif (is_numeric($news['created_at'])) {
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
                    </p>

                    <?php if (!empty($news['image'])): ?>
                        <img src="<?= htmlspecialchars($news['image']) ?>" alt="News Image" width="100"><br><br>
                    <?php endif; ?>

                    <p><strong>Summary:</strong> <?= htmlspecialchars($news['summary']) ?></p>

                    <a href="read.php?id=<?= $news['_id'] ?>">Read Full Article</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</body>

</html>