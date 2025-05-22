<?php
include "db.php";
$id = "";
$username = "";
$fullname = "";
$foto = "";
$password = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    $username = $data['username'];
    $fullname = $data['fullname'];
    $foto = $data['foto'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $fotoBaru = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir);
    }

    if ($fotoBaru) {
        move_uploaded_file($tmp, $uploadDir . $fotoBaru);
    }

    if ($id) {
        // UPDATE
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET username=?, fullname=?, password=?, foto=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $username, $fullname, $hash, $fotoBaru ?: $foto, $id);
        } else {
            $sql = "UPDATE users SET username=?, fullname=?, foto=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $fullname, $fotoBaru ?: $foto, $id);
        }
    } else {
        // INSERT
        $hash = password_hash($password, PASSWORD_DEFAULT);
        move_uploaded_file($tmp, $uploadDir . $fotoBaru);
        $sql = "INSERT INTO users (username, fullname, password, foto) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $fullname, $hash, $fotoBaru);
    }

    $stmt->execute();
    header("Location: users.php");
    exit;
}
?>

<h2><?= $id ? "Edit" : "Tambah" ?> User</h2>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $id ?>">
    Username: <input type="text" name="username" value="<?= $username ?>" required><br>
    Full Name: <input type="text" name="fullname" value="<?= $fullname ?>" required><br>
    Password: <input type="password" name="password" <?= $id ? "" : "required" ?>> <?= $id ? "<small>(Kosongkan jika tidak diubah)</small>" : "" ?><br>
    Foto: <input type="file" name="foto"><br>
    <?php if ($foto): ?>
        <img src="uploads/<?= $foto ?>" width="60"><br>
    <?php endif; ?>
    <button type="submit"><?= $id ? "Update" : "Tambah" ?></button>
</form>
<a href="users.php">Kembali</a>
