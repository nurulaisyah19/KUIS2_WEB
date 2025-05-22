<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
$user = $_SESSION['user'];
?>

<h2>Selamat datang, <?= $user['fullname']; ?></h2>
<img src="uploads/<?= $user['foto']; ?>" width="100"><br>
<a href="users.php">Kelola User</a> | <a href="logout.php">Logout</a>
