<?php
session_start();
$bookId = $_GET['book_id']; // Replace with the actual book ID
$authorId = $_GET['author_id']; // Replace with the actual author ID
$authorizationToken = $_SESSION['access_token'];

$ch = curl_init();

// Set the URL for the DELETE request
$deleteBookUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/books/' . $bookId;

// Set cURL options for the DELETE request
curl_setopt($ch, CURLOPT_URL, $deleteBookUrl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: */*',
    'Authorization: ' . $authorizationToken,
]);

// Execute the DELETE request
$response = curl_exec($ch);

// Check the HTTP response code
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode === 204) {
    // Book deletion was successful
    // Redirect to authors.php with the specified author_id
    header('Location: authors.php?author_id=' . $authorId);
    exit();
} else {
    // Handle the case when book deletion fails
    echo 'Unable to delete book. HTTP Code: ' . $httpCode;
}

// Close cURL session
curl_close($ch);
