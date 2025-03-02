<?php
require_once "config.php"; // Load API key

if (!isset($_GET['ip']) || empty($_GET['ip'])) {
    header("Location: index.php?message=Please enter a valid IP address.");
    exit();
}

$ip = trim($_GET['ip']);
$apiUrl = "https://api.greynoise.io/v3/community/" . urlencode($ip);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["key: " . GREYNOISE_API_KEY]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

if ($httpCode === 200) {
    // Successfully retrieved data
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search Result</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h1>Search Result for ' . htmlspecialchars($ip) . '</h1>
            <div class="success">
                <p><strong>IP Address:</strong> ' . htmlspecialchars($data['ip']) . '</p>
                <p><strong>Noise:</strong> ' . ($data['noise'] ? "Yes" : "No") . '</p>
                <p><strong>Riot:</strong> ' . ($data['riot'] ? "Yes" : "No") . '</p>
                <p><strong>Classification:</strong> ' . htmlspecialchars($data['classification']) . '</p>
                <p><strong>Owner:</strong> ' . htmlspecialchars($data['name']) . '</p>
                <p><strong>Last Seen:</strong> ' . htmlspecialchars($data['last_seen']) . '</p>
                <p><strong>More Info:</strong> <a href="' . htmlspecialchars($data['link']) . '" target="_blank">GreyNoise Link</a></p>
            </div>
            <br>
            <a href="index.php">Search Again</a>
        </div>
    </body>
    </html>';
} else {
    // API errors
    $errorMessage = $data['message'] ?? "Unknown error occurred.";
    header("Location: index.php?message=" . urlencode($errorMessage));
    exit();
}
