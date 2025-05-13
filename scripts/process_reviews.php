<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validation to make sure user is logged in and the form has all required fields
if (!isset($_SESSION['user']) || !isset($_POST['phone_id'], $_POST['rating'], $_POST['comment'])) {   
    header("Location: /Phone_CompareSite/phone_comparison_site/index.php");
    exit();
}

// Path to where reviews are stored
$reviewsFile = '../data/reviews.json';

// Load existing reviews, or use an empty array if the file doesn't exist
$reviews = file_exists($reviewsFile) ? json_decode(file_get_contents($reviewsFile), true) : [];

// Build the array using posted data
$review = [
    "review_id" => count($reviews) + 1,
    "user_id" => $_SESSION['user']['id'],
    "username" => $_SESSION['user']['username'],
    "phone_id" => intval($_POST['phone_id']),
    "rating" => intval($_POST['rating']),
    "comment" => trim($_POST['comment']),
    "timestamp" => date("Y-m-d H:i:s")
];

// Add the new review to the list
$reviews[] = $review;

// Save updated reviews list back to the file
file_put_contents($reviewsFile, json_encode($reviews, JSON_PRETTY_PRINT));

// Redirect back to the phone page with the selected phone ID
header("Location: /Phone_CompareSite/phone_comparison_site/phone.php?id=" . $_POST['phone_id']);
exit();