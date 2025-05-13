<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
// remove when finished

require_once "../page_assets/masterPage.php";
require_once "../phone_comparison_site/api/bll.ranking.php";
require_once "../content/recommendations.php"; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$phonesData = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/Phone_CompareSite/data/phones.json'), true);

// Only if user logged in
$favouritePhone = '';
if (isset($_SESSION['user'])) {
    $favouritePhone = $_SESSION['user']['favourite_phone'] ?? '';
}

$phoneManager = new PhoneManager();
$phoneManager->loadPhones('../data/phones.json');
$phones = $phoneManager->getAllPhones();

// Assemble Page
$masterPage = new MasterPage("Phone Rankings");
$masterPage->setMainContentTop(createRankingContentTop($phones));
$masterPage->setMainContentBottom(createRankingContentBottom($phones, $recommendations));
$masterPage->setSidebarTop(createRankingSidebarTop($favouritePhone, $phonesData));
$masterPage->setSidebarBottom(createRankingSidebarBottom());
$masterPage->renderPage();
?>
<script src="/Phone_CompareSite/js/filter.js"></script>