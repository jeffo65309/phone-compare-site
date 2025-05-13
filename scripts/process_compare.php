<?php
// Make sure a phone ID was passed in the request
if (!isset($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Missing phone ID']);
    exit;
}

$phoneId = $_GET['id'];

// Load all phones from JSON
$phones = json_decode(file_get_contents('../data/phones.json'), true);

// Loop through each phone and try to match the ID
foreach ($phones as $phone) {
    if ($phone['id'] == $phoneId) {
        echo json_encode($phone); /
        exit;
    }
}

// If no match was found, return a 404 response
http_response_code(404);
echo json_encode(['error' => 'Phone not found']);
?>
