<?php

// Updates user profile information
function displayOrUpdate($label, $field, $value) {
    return "
    <form action='../scripts/process_updateProfile.php' method='POST' class='mb-2'>
        <label class='form-label'><strong>{$label}:</strong></label>
        <input type='text' name='{$field}' class='form-control' value='" . htmlspecialchars($value) . "' required>
        <button type='submit' class='btn btn-sm btn-primary mt-1'>Save</button>
    </form>";
}

// Load and filter reviews for phone
function getReviewsHtmlForPhone($phoneId, $phoneManager) {
    $reviewsFile = __DIR__ . '/../data/reviews.json';
    if (!file_exists($reviewsFile)) return "<p class='text-muted'>No reviews file found.</p>";

    $reviews = json_decode(file_get_contents($reviewsFile), true);
    if (!is_array($reviews)) return "<p class='text-muted'>No reviews available.</p>";

    $output = "";

    foreach ($reviews as $review) {
        if ($review['phone_id'] == $phoneId) {
            $phone = $phoneManager->getPhoneById($review['phone_id']);
            $output .= "<div class='border rounded p-2 mb-3'>
                <strong>" . htmlspecialchars($review['username']) . "</strong> reviewed <strong>{$phone->manufacturer} {$phone->model}</strong><br>
                <span>Rating: {$review['rating']} / 5</span><br>
                <small>{$review['timestamp']}</small>
                <p class='mt-1'>" . htmlspecialchars($review['comment']) . "</p>
            </div>";
        }
    }

    return $output ?: "<p class='text-muted'>No reviews available yet.</p>";
}

// Generates JavaScript to preload a comparison slot 
function getCompareInitScript(): string {
    if (isset($_GET['compare']) && isset($_GET['slot'])) {
        $compareId = intval($_GET['compare']);
        $slot = intval($_GET['slot']);

        return <<<HTML
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                loadCompareSlot({$compareId}, {$slot});
            });
        </script>
        HTML;
    }
    return '';
}


// Safely clean user input 
function safeInput($input) {
    return htmlspecialchars(trim(strip_tags($input)), ENT_QUOTES, 'UTF-8');
}

// Load a JSON file safely
function loadJsonFile($filepath) {
    if (!file_exists($filepath)) {
        return []; // Return empty array if file doesn't exist
    }
    $json = file_get_contents($filepath);
    $data = json_decode($json, true);
    if (!is_array($data)) {
        return []; // Return empty array if JSON is invalid
    }
    return $data;
}

// Save a JSON array back to a file safely
function saveJsonFile($filepath, $data) {
    file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT));
}

// Flash messages success/error
function getFlashMessages() {
    $messages = '';
    if (isset($_SESSION['success'])) {
        $messages .= '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        $messages .= '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    return $messages;
}


// Validate email format
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Validate password (
function validatePassword($password) {
    return strlen($password) >= 6;
}

// Load users from users.json safely
function loadUsers() {
    $filepath = __DIR__ . '/../data/users.json';
    if (!file_exists($filepath)) {
        return [];
    }
    $json = file_get_contents($filepath);
    $data = json_decode($json, true);
    if (!is_array($data)) {
        return [];
    }
    return $data;
}


function logoutUser() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Destroy session, redirect 
    session_unset();   
    session_destroy(); 
    
    header("Location: /Phone_CompareSite/phone_comparison_site/index.php");
    exit();
}

// Star ratings bootstrap icons based on a number like 4.5
function renderStars($rating) {
    $stars = '';
    $fullStars = floor($rating); // how many full stars
    $halfStar = ($rating - $fullStars) >= 0.5 ? true : false;

    for ($i = 0; $i < $fullStars; $i++) {
        $stars .= '<i class="bi bi-star-fill text-warning"></i>';
    }

    if ($halfStar) {
        $stars .= '<i class="bi bi-star-half text-warning"></i>';
    }

    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    for ($i = 0; $i < $emptyStars; $i++) {
        $stars .= '<i class="bi bi-star text-warning"></i>';
    }

    return $stars;
}