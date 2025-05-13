<?php

// ===== HOMEPAGE BUSINESS LOGIC (bll.home.php) =====




function createIndexContentTop() {

     // Load the intro content from the content folder
     $extraContent = file_get_contents(__DIR__ . '/../../content/index_intro.html');

    return <<<HTML
        <div class="p-4 mb-4 bg-light border rounded">
            <h2>Welcome to the Phone Comparison Site</h2>
            <p class="lead">Compare the latest smartphones and find your perfect match.</p>
            {$extraContent}
        </div>
        
    HTML;   
}


function createIndexContentBottom() {
    require_once "../phone_comparison_site/api/bll.review.php";
    $reviewsHtml = getLatestReviewsHtml();
    return <<<HTML
        <h3>Latest Reviews</h3>
        <p>Check out our latest smartphone reviews to help with your choice.</p>
        {$reviewsHtml}
    HTML;
}


function getSidebarTopModals() {
    ob_start();
    include '../phone_comparison_site/login.php';
    $loginForm = ob_get_clean();

    ob_start();
    include '../phone_comparison_site/register.php';
    $registerForm = ob_get_clean();

    return <<<HTML
        <div class="mb-3">
            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
        </div>

        <!-- Login -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        $loginForm
                    </div>
                </div>
            </div>
        </div>

        <!-- Register -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Register</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        $registerForm
                    </div>
                </div>
            </div>
        </div>
    HTML;
}


function getSidebarBottomAd() {
    $extraPath = __DIR__ . '/../../content/phone_salesInfo.html';

    if (file_exists($extraPath)) {
        return '<div class="p-3 border rounded bg-light mt-4">' . file_get_contents($extraPath) . '</div>';
    } else {
        return '<p class="text-danger">Deals content could not be loaded.</p>';
    }
}
