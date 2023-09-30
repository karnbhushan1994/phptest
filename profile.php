<?php
session_start(); // Start the session to access stored variables

// Check if the user is logged in (has a valid access token)
if (!isset($_SESSION['access_token'])) {
    // Redirect the user to the login page
    header('Location: index.php');
    exit();
}

$accessToken = $_SESSION['access_token'];

// Create a function to get the user's profile data
function getProfileData($accessToken)
{
    // Define your API endpoint for getting profile data
    $profileApiUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/me';

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options for the GET request
    curl_setopt($ch, CURLOPT_URL, $profileApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'Authorization: ' . $accessToken,
    ]);

    // Execute the GET request
    $response = curl_exec($ch);

    // Check if the GET request was successful
    if ($response) {
        // Decode the JSON response into an associative array
        return json_decode($response, true);
    } else {
        return false;
    }
}

// Get the user's profile data
$profileData = getProfileData($accessToken);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
</head>

<body>
    <h1>Profile</h1>
    <?php if ($profileData) { ?>
        <p>Welcome, <?php echo $profileData['first_name'] . ' ' . $profileData['last_name']; ?>!</p>
        <p>Email: <?php echo $profileData['email']; ?></p>
        <p>Gender: <?php echo $profileData['gender']; ?></p>
        <p>Active: <?php echo $profileData['active'] ? 'Yes' : 'No'; ?></p>
    <?php } else { ?>
        <p>Unable to fetch profile data.</p>
    <?php } ?>
    <p><a href="secured_page.php">Back to authors list</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>

</html>