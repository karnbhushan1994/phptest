<?php
session_start(); // Start the session to access stored variables

if (!isset($_SESSION['access_token'])) {
    // Redirect the user to the login page
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add New Book</title>
</head>

<body>
    <h1>Add a New Book</h1>
    <form action="add_book.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="release_date">Release Date:</label>
        <input type="date" id="release_date" name="release_date" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required><br><br>

        <label for="format">Format:</label>
        <input type="text" id="format" name="format" required><br><br>

        <label for="number_of_pages">Number of Pages:</label>
        <input type="number" id="number_of_pages" name="number_of_pages" required><br><br>

        <label for="author">Author:</label>
        <select id="author" name="author" required>
            <?php include('get_authors.php'); ?>
        </select><br><br>


        <input type="submit" value="Add Book">
    </form>
</body>

</html>