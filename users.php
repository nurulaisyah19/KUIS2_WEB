<?php
include "db.php";
$result = $conn->query("SELECT * FROM users");
?>

<h2>Data Users</h2>
<a href="user_form.php">+ Tambah User</a><br><br>
<table border="1">
    <tr><th>Username</th><th>Full Name</th><th>Foto</th><th>Aksi</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['username'] ?></td>
        <td><?= $row['fullname'] ?></td>
        <td><img src="uploads/<?= $row['foto'] ?>" width="50"></td>
        <td>
            <a href="user_form.php?id=<?= $row['id'] ?>">Edit</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="dashboard.php">Kembali</a>
