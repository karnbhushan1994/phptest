<?php
session_start(); // Start the session to access stored variables

// Check if the user is logged in (has a valid access token)
if (!isset($_SESSION['access_token'])) {
    // Redirect the user to the login page
    header('Location: index.php');
    exit();
}

$accessToken = $_SESSION['access_token'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authorizationToken =  $accessToken;

    // Retrieve form data
    $authorId = $_POST['author'];
    $title = $_POST['title'];
    $releaseDate = $_POST['release_date'];
    $description = $_POST['description'];
    $isbn = $_POST['isbn'];
    $format = $_POST['format'];
    $numberOfPages = $_POST['number_of_pages'];

    // Construct the book data array
    $bookData = [
        'author' => [
            'id' => $authorId,
        ],
        'title' => $title,
        'release_date' => $releaseDate,
        'description' => $description,
        'isbn' => $isbn,
        'format' => $format,
        'number_of_pages' => intval($numberOfPages),
    ];

    $ch = curl_init();

    // Set the URL for the POST request
    $postBookUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/books';

    // Set cURL options for the POST request
    curl_setopt($ch, CURLOPT_URL, $postBookUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'Authorization: ' . $authorizationToken,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bookData));

    // Execute the POST request
    $response = curl_exec($ch);

    // Check the HTTP response code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode === 200) {
        // Book creation was successful
        echo 'Book has been created successfully.';
        sleep(2);
        header('Location: secured_page.php');
        exit();
        // You can also handle the response data here if needed
    } else {
        // Handle the case when book creation fails
        echo 'Unable to create book. HTTP Code: ' . $httpCode;
    }

    // Close cURL session
    curl_close($ch);
}
