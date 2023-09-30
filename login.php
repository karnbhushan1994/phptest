<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ch = curl_init();

    // Set the API endpoint URL
    $loginUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/token';

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Set cURL options for the login request
    curl_setopt($ch, CURLOPT_URL, $loginUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'email' => $email,
        'password' => $password,
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
    ]);

    // Execute cURL session and capture the response
    $response = curl_exec($ch);

    if ($response) {
        $data = json_decode($response, true);

        if (isset($data['token_key'])) {
            // Store the access token securely, e.g., in a session
            session_start();
            $_SESSION['access_token'] = $data['token_key'];

            // Redirect to a secured page
            header('Location: secured_page.php');
            exit();
        } else {
            echo 'Login failed.';
        }
    } else {
        echo 'Unable to connect to the server.';
    }

    // Close cURL session
    curl_close($ch);
}
