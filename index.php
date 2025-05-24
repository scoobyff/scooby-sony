<?php
// Set CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

$get = $_GET['get'];
$mpdUrl = 'https://pubads.g.doubleclick.net/' . $get;

// Set headers for fetching remote
$mpdheads = [
  'http' => [
            'header' => "User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36",
      'follow_location' => 1,
      'timeout' => 5
  ]
];
$context = stream_context_create($mpdheads);

// Fetch and output
$res = @file_get_contents($mpdUrl, false, $context);

if ($res === false) {
    http_response_code(502);
    echo "Failed to fetch resource.";
} else {
    // Optionally forward content-type
    header("Content-Type: application/dash+xml");
    echo $res;
}
?>
