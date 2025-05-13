<?php

// ===== BUSINESS LOGIC (bll.review.php) =====

function getLatestReviewsHtml($limit = 6) {
    // File paths
    $reviewsFile = $_SERVER['DOCUMENT_ROOT'] . '/Phone_CompareSite/data/reviews.json';
    $phonesFile = $_SERVER['DOCUMENT_ROOT'] . '/Phone_CompareSite/data/phones.json';

    if (!file_exists($reviewsFile) || !file_exists($phonesFile)) return "<p>No reviews yet.</p>";

    // Turns the JSON data into arrays
    $reviews = json_decode(file_get_contents($reviewsFile), true);
    $phones = json_decode(file_get_contents($phonesFile), true);

    // Return errors 
    if (!is_array($reviews) || !is_array($phones)) return "<p>Error loading reviews or phones data.</p>";

  // Map phone IDs to phone data
    $phoneMap = [];
    foreach ($phones as $phone) {
        $phoneMap[$phone['id']] = $phone;
    }

    // Sort reviews by timestamp
    usort($reviews, fn($a, $b) => strtotime($b['timestamp']) - strtotime($a['timestamp']));
    // Get the latest reviews
    $latestReviews = array_slice($reviews, 0, $limit);

    // Create the review card HTML
    $output = "<div class='row'>";
    foreach ($latestReviews as $review) {
        $user = htmlspecialchars($review['username']);
        $comment = htmlspecialchars($review['comment']);
        $rating = (int)$review['rating'];
        $stars = str_repeat("⭐", $rating);

        $phone = $phoneMap[$review['phone_id']] ?? null;
        $phoneImage = $phone ? $phone['image'] : '../assets/images/placeholder.jpg';
        $phoneModel = $phone ? htmlspecialchars($phone['model']) : 'Unknown Phone';

        $output .= <<<HTML
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="{$phoneImage}" alt="{$phoneModel}" class="img-fluid rounded-start" style="object-fit: cover; height: 100%;">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <h5 class="card-title mb-1">{$user}</h5>
                            <p class="card-text mb-1"><strong>{$phoneModel}</strong></p>
                            <p class="card-text mb-1"><span>{$stars}</span></p>
                            <p class="card-text"><small>{$comment}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }
    $output .= "</div>";

    return $output;
}