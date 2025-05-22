<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $foto = $_FILES["foto"]["name"];
    $tmp  = $_FILES["foto"]["tmp_name"];
    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir);
    }

    move_uploaded_file($tmp, $uploadDir . $foto);

    $sql = "INSERT INTO users (username, fullname, password, foto) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $fullname, $password, $foto);
    $stmt->execute();

    echo "User berhasil ditambahkan. <a href='index.php'>Login</a>";
    exit;
}
?>

<h2>Register</h2>
<form method="post" enctype="multipart/form-data">
    Username: <input type="text" name="username"><br>
    Full Name: <input type="text" name="fullname"><br>
    Password: <input type="password" name="password"><br>
    Foto: <input type="file" name="foto"><br>
    <button type="submit">Register</button>
</form>
