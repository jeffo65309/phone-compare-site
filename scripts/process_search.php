<?php
// Gets the search from the URL 
$term = strtolower(trim($_GET['q'] ?? ''));

// Load phone data from the JSON file
$phones = json_decode(file_get_contents('../data/phones.json'), true);
$results = [];

// Loop through each phone and match against search 
foreach ($phones as $phone) {
    $name = $phone['manufacturer'] . ' ' . $phone['model'];

    // If the term exists anywhere in the name, this add to results
    if (stripos($name, $term) !== false) {
        $results[] = [
            'id' => $phone['id'],
            'manufacturer' => $phone['manufacturer'],
            'model' => $phone['model']
        ];
    }
}

// Set header so JavaScript knows it's JSON
header('Content-Type: application/json');

// Return the results as JSON
echo json_encode($results);
?>