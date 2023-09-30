<?php session_start();

if (isset($_SESSION['access_token'])) {
    header('Location: secured_page.php');
    exit();
} ?>

<!-- login.html -->
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>