<?php
require_once '../../app/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = connectMongoDB();
    $collection = $db->admin_login;

    $username = $_POST['username'];
    $password = trim($_POST['password']); // User input password

    // Fetch the admin from MongoDB based on username
    $admin = $collection->findOne(['username' => $username]);

    // Directly compare the password (no hashing)
    if ($admin && $password === $admin['password']) {
        $_SESSION['admin'] = $admin['username'];
        header("Location: ./dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
</head>

<body>
    <h1>Admin Login</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</body>

</html>