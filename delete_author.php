<?php
session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
    exit();
}

$accessToken = $_SESSION['access_token'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['author_id'])) {
    $authorId = $_GET['author_id'];

    // Build the DELETE request URL
    $deleteAuthorUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/authors/' . $authorId;

    // Initialize cURL session for DELETE request
    $ch = curl_init($deleteAuthorUrl);

    // Set cURL options for the DELETE request
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Accept: */*', // You can change this to 'application/json' if the API expects JSON response
    ]);

    // Execute the DELETE request
    $response = curl_exec($ch);

    if ($response !== false) {
        // Check the HTTP response code to determine if the deletion was successful
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode === 204) {
            // Author deletion was successful
            header('Location: secured_page.php'); // Redirect to the author listing page
            exit();
        } else {
            // Handle the case when author deletion fails
            echo 'Unable to delete author. HTTP Code: ' . $httpCode;
        }
    } else {
        // Handle the case when the DELETE request itself fails
        echo 'Failed to delete author. cURL Error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);
} else {
    // Handle invalid request
    echo 'Invalid request.';
}
