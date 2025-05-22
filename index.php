<?php
session_start();
?>
<h2>Login</h2>
<form action="login.php" method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <button type="submit">Login</button>
</form>
Belum punya akun? <a href="register.php">Register</a>
