<?php
// Start the session to access stored variables
session_start();

// Destroy the session to log the user out
session_destroy();

// Redirect the user to the login page (you can change the URL as needed)
header('Location: index.php');
exit();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Logout</title>
</head>

<body>
    <h1>Logout</h1>
    <p>You have been successfully logged out.</p>

    <p><a href="login.php">Login Again</a></p>
</body>

</html>