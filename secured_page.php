<?php
session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
    exit();
}

$accessToken = $_SESSION['access_token'];

$ch = curl_init();

// Set the API endpoint URL for fetching authors
$authorsUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/authors';

// Specify query parameters for sorting, pagination, etc.
$queryParams = [
    'orderBy' => 'id',
    'direction' => 'DESC',
    'limit' => 1500,
    'page' => 1,
];

// Build the URL with query parameters
$authorsUrl .= '?' . http_build_query($queryParams);

// Set cURL options for the GET request
curl_setopt($ch, CURLOPT_URL, $authorsUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Accept: application/json',
]);
echo '<a href="create_author.html">Author Create</a><br></br>';
echo '<a href="profile.php">Profile</a><br></br>';
echo '<a href="add_book_by_author.php">Add  Book</a>';
// Execute cURL session and capture the response
$response = curl_exec($ch);

if ($response) {
    $authors = json_decode($response, true);
    // Display authors in a table
    echo '<table>';
    echo '<tr><th>ID</th><th>Name</th><th>Delete</th></tr>';
    foreach ($authors['items'] as $author) {
        echo '<tr>';
        echo '<td>' . $author['id'] . '</td>';
        echo '<td>' . $author['first_name'] . ' ' . $author['last_name'] . '</td>';
        echo '<td><a href="delete_author.php?author_id=' . $author['id'] . '">Delete</a></td>';
        echo '<td><a href="authors.php?author_id=' . $author['id'] . '">Authors</a></td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'Unable to fetch authors.';
}

// Close cURL session
curl_close($ch);
