<?php

// ===== PHONEPAGE BUSINESS LOGIC (bll.phone.php) =====

class Phone {
    public $id;
    public $model;
    public $price;
    public $os;
    public $manufacturer;
    public $image;
    public $release_date;
    public $screen_size;
    public $resolution;
    public $cameras;
    public $weight;
    public $battery;
    public $processor;
    public $storage;
    public $customer_rating;

    public function __construct($id, $model, $price, $os, $manufacturer, $image, $release_date, $screen_size, $resolution, $cameras, $weight, $battery, $processor, $storage, $customer_rating) {
        $this->id = $id;
        $this->model = $model;
        $this->price = $price;
        $this->os = $os;
        $this->manufacturer = $manufacturer;
        $this->image = $image;
        $this->release_date = $release_date;
        $this->screen_size = $screen_size;
        $this->resolution = $resolution;
        $this->cameras = $cameras;
        $this->weight = $weight;
        $this->battery = $battery;
        $this->processor = $processor;
        $this->storage = $storage;
        $this->customer_rating = $customer_rating;
    }

    // You can add any methods here to manipulate or format data specific to a phone
    public function formatPrice() {
        return "£" . number_format($this->price, 2);
    }
}

require_once "bll.phone.php"; // make sure this file contains the Phone class

// Create carousel of phones
function createPhoneCarousel($phoneManager): string {
    $html = '<h2>Phone Comparison</h2><p>Browse and compare various smartphones to find the perfect one for you.</p><div id="phoneCarousel" class="carousel slide" data-bs-ride="carousel"><div class="carousel-inner">';

    foreach ($phoneManager->getAllPhones() as $index => $phone) {
        $activeClass = $index === 0 ? 'active' : '';
        $html .= <<<HTML
            <div class="carousel-item {$activeClass}">
                <div class="card compare-select" data-id="{$phone->id}" style="cursor: pointer;">
                    <img src="{$phone->image}" class="card-img-top" alt="{$phone->model}" style="height: 400px; width: 100%; object-fit: contain; background-color: #f8f9fa;">
                    <div class="card-body">
                        <h5 class="card-title">{$phone->manufacturer} {$phone->model}</h5>
                        <p class="card-text">
                            <strong>Price:</strong> {$phone->formatPrice()}<br>
                            <strong>Release Date:</strong> {$phone->release_date}<br>
                            <strong>OS:</strong> {$phone->os}<br>
                            <strong>Screen Size:</strong> {$phone->screen_size}<br>
                            <strong>Resolution:</strong> {$phone->resolution}<br>
                            <strong>Cameras:</strong> {$phone->cameras}<br>
                            <strong>Weight:</strong> {$phone->weight}<br>
                            <strong>Battery:</strong> {$phone->battery}<br>
                            <strong>Processor:</strong> {$phone->processor}<br>
                            <strong>Storage:</strong> {$phone->storage}<br>
                            <strong>Customer Rating:</strong> {$phone->customer_rating} / 5
                        </p>
                    </div>
                </div>
            </div>
        HTML;
    }

    $html .= '</div>
        <button class="carousel-control-prev" type="button" data-bs-target="#phoneCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#phoneCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>';

    return $html;
}

function createReviewSection(string $recentReviewsHtml): string {
    $html = <<<HTML
    <div id="selected-phone-review" class="mt-4">
        <h2>Latest Reviews</h2> 
        <div id="recentReviews">
            {$recentReviewsHtml}
        </div>

        <div id="selectedPhoneCard" class="card mb-3 p-2" style="display: none;"></div>
        
        <div id="reviewFormWrapper" style="display: none;">
            <!-- Form to leave review -->
            <h4 class="mt-3">Leave a Review</h4>
            <form id="reviewForm" action="/Phone_CompareSite/scripts/process_reviews.php" method="POST">
                <input type="hidden" name="phone_id" id="selectedPhoneId">
                <div class="mb-2">
                    <label for="rating" class="form-label">Rating (1-5):</label>
                    <input type="number" name="rating" class="form-control" min="1" max="5" required>
                </div>
                <div class="mb-2">
                    <label for="comment" class="form-label">Comment:</label>
                    <textarea name="comment" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit Review</button>
            </form>
        </div>
    </div>
    HTML;

    return $html;
}

// Sidebar helpers
function createPhoneSidebarTop(): string {
    $extraPath = __DIR__ . '/../../content/phone_salesInfo.html';

    if (file_exists($extraPath)) {
        return '<div class="p-3 border rounded bg-light mt-4">' . file_get_contents($extraPath) . '</div>';
    } else {
        return '<p class="text-danger">Deals content could not be loaded.</p>';
    }
}

function createPhoneSidebarBottom(): string {
    return <<<HTML
        <h3>Compare Phones</h3>
        <div class="d-flex justify-content-end mb-3">
            <button id="resetCompareBtn" class="btn btn-danger" style="margin-bottom: 10px;">Reset Comparison</button>
        </div>
        <div id="compare-section" class="row">
            <div id="phone1" class="col-md-6 border p-2"></div>
            <div id="phone2" class="col-md-6 border p-2"></div>
        </div>
    HTML;
}