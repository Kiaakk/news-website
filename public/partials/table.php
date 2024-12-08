<div class="row text-center bg-dark rounded text-light py-2 mb-4 fw-bold">
    <div class="col-3">
        Title
    </div>
    <div class="col-5">
        Content
    </div>
    <div class="col-1">
        Author
    </div>
    <div class="col-2">
        Published Date
    </div>
    <div class="col-1">
        Action
    </div>
</div>

<div class="row mb-3">
    <?php foreach ($newsArray as $news): ?>
        <div class="col-3">
            <?= htmlspecialchars($news['title']) ?>
        </div>
        <div class="col-5">
            <?= htmlspecialchars($news['content']) ?>
        </div>
        <div class="col-1">
            <?= htmlspecialchars($news['author']) ?>
        </div>
        <div class="col-2">
            <?php
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


        </div>

        <div class="col-1">
            <div class="d-flex flex-column">
                <a href="?delete=<?= $news['_id'] ?>" onclick="return confirm('Are you sure you want to delete this news?')"><button type="button" class="text-start btn btn-sm btn-outline-danger border-0" data-bs-toggle="modal" data-bs-target="#hapus">Delete</button>
                </a>

                <a href="edit.php?id=<?= $news['_id'] ?>"><button type="button" class="text-start btn btn-sm btn-outline-primary border-0">Edit</button></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="hapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">Are you sure you want to Delete this News?</div>
                <div class="container">
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <button type="button" class="btn btn-danger w-25 me-2">Yes</button>
                        <button type="button" class="btn btn-secondary w-25 px-3" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>