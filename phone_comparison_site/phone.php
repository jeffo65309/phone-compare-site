<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../page_assets/masterPage.php";
require_once "../phone_comparison_site/api/bll.phone.php";
require_once "../phone_comparison_site/api/bll.review.php"; 

// Load phones
$phoneManager = new PhoneManager();
$phoneManager->loadPhones("../data/phones.json");

// Get dynamic sections
$mainContentTop = createPhoneCarousel($phoneManager);
$mainContentBottom = createReviewSection(getLatestReviewsHtml());
$sidebarTop = createPhoneSidebarTop();         
$sidebarBottom = createPhoneSidebarBottom();    
$compareInitScript = getCompareInitScript();

// Assemble page
$masterPage = new MasterPage("Phone Comparison");
$masterPage->setMainContentTop($mainContentTop);
$masterPage->setMainContentBottom($mainContentBottom . $compareInitScript); // include script in bottom
$masterPage->setSidebarTop($sidebarTop);
$masterPage->setSidebarBottom($sidebarBottom);
$masterPage->renderPage();

?>
