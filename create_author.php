<?php
session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
    exit();
}

$accessToken = $_SESSION['access_token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $newAuthorData = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'birthday' => $_POST['birthday'],
        'biography' => $_POST['biography'],
        'gender' => $_POST['gender'],
        'place_of_birth' => $_POST['place_of_birth'],
    ];

    $ch = curl_init();

    // Set the API endpoint URL for creating authors
    $createAuthorUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/authors';

    // Convert the author data to form data format
    $formData = http_build_query($newAuthorData);

    // Set cURL options for the POST request with form data
    curl_setopt($ch, CURLOPT_URL, $createAuthorUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/x-www-form-urlencoded',
        'Accept: application/json',
    ]);

    // Execute cURL session and capture the response
    $response = curl_exec($ch);

    if ($response) {
        $responseData = json_decode($response, true);

        if (isset($responseData['id'])) {
            // Author created successfully
            header('Location: secured_page.php');
            // echo 'Author created with ID: ' . $responseData['id'];
        } else {
            echo 'Failed to create author.';
        }
    } else {
        echo 'Error creating author: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);
}
