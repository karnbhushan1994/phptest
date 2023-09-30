<?php
session_start(); // Start the session to access stored variables

// Check if the user is logged in (has a valid access token)
if (!isset($_SESSION['access_token'])) {
    // Redirect the user to the login page
    header('Location: index.php');
    exit();
}
$authorizationToken = $_SESSION['access_token'];

$ch = curl_init();

// Set the URL for the GET request to retrieve authors
$getAuthorsUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/authors?orderBy=id&direction=ASC&limit=1500&page=1';

// Set cURL options for the GET request
curl_setopt($ch, CURLOPT_URL, $getAuthorsUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'Authorization: ' . $authorizationToken,
]);

// Execute the GET request
$response = curl_exec($ch);

// Check if the GET request was successful
if ($response) {
    // Parse the JSON response into an array
    $authorsData = json_decode($response, true);


    // Generate the dropdown options
    if (!empty($authorsData['items'])) { // Use $authorsData['items'] to access the authors array
        foreach ($authorsData['items'] as $author) {
            echo '<option value="' . $author['id'] . '">' . $author['first_name'] . ' ' . $author['last_name'] . '</option>';
        }
    } else {
        echo '<option value="">No authors available</option>';
    }
} else {
    echo '<option value="">Unable to fetch authors</option>';
}


// Close cURL session
curl_close($ch);
