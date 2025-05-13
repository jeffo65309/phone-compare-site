<?php

require_once '../page_assets/masterpage.php';

// Get the search term from the URL and clean it up 
$term = strtolower(trim($_GET['q'] ?? ''));

// Load all phones from the JSON data file
$phones = json_decode(file_get_contents('../data/phones.json'), true);
$results = [];

// Search for any phones where the manufacturer or model matches the input
foreach ($phones as $phone) {
    $name = $phone['manufacturer'] . ' ' . $phone['model'];
    if (stripos($name, $term) !== false) {
        $results[] = $phone;
    }
}

// Start building the main content
$content = '<h2>Search Results for "' . htmlspecialchars($term) . '"</h2>';

if ($results) {
    foreach ($results as $phone) {
        // Show a simple preview for each match
        $content .= '<div class="mb-3 p-2 border rounded">
            <h4><a href="phone.php?id=' . $phone['id'] . '">' . htmlspecialchars($phone['manufacturer'] . ' ' . $phone['model']) . '</a></h4>
            <p>' . htmlspecialchars($phone['description']) . '</p>
        </div>';
    }
} else {
    // No matches found
    $content .= '<p>No results found.</p>';
}

// Use the master layout to render the page
$page = new MasterPage("Search Results");
$page->setMainContentTop($content);
$page->renderPage();
?>