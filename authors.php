<?php
session_start(); // Start the session to access stored variables

// Check if the user is logged in (has a valid access token)
if (!isset($_SESSION['access_token'])) {
    // Redirect the user to the login page
    header('Location: index.php');
    exit();
}

$accessToken = $_SESSION['access_token'];
echo $accessToken;
$ch = curl_init();

// Set the author ID you want to retrieve
$authorId = $_GET['author_id'];

// Set the API endpoint URL for fetching a single author
$authorUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/authors/' . $authorId;

// Set cURL options for the request
curl_setopt($ch, CURLOPT_URL, $authorUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Accept: application/json',
]);

// Execute cURL session and capture the response
$response = curl_exec($ch);

if ($response) {
    $authorData = json_decode($response, true);
    echo '<a href="secured_page.php">Authors List</a>';
    // Display author information
    echo '<h1>' . $authorData['first_name'] . ' ' . $authorData['last_name'] . '</h1>';
    echo '<p>Birthday: ' . $authorData['birthday'] . '</p>';
    echo '<p>Biography: ' . $authorData['biography'] . '</p>';

    // Check if the author has books
    if (isset($authorData['books']) && !empty($authorData['books'])) {
        echo '<h2>Books by ' . $authorData['first_name'] . ' ' . $authorData['last_name'] . '</h2>';
        echo '<ul>';
        foreach ($authorData['books'] as $book) {
            echo '<li>' . $book['title'] . ' - <a href="delete_single_book.php?book_id=' . $book['id'] . '&author_id=' . $authorId . '">Delete</a></li>';
        }
        echo '</ul>';
    } else {

        echo '<a href="delete_author.php?author_id=' . $authorId . '">Delet Authors</a>';
    }
} else {
    echo 'Unable to fetch author data.';
}

// Close cURL session
curl_close($ch);
