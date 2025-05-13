<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../page_assets/functions.php"; 
require_once "../page_assets/masterPage.php";
require_once "../phone_comparison_site/api/bll.home.php"; 
require_once "../phone_comparison_site/api/bll.review.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



//Build page content normally
$mainContentTop = getFlashMessages() . createIndexContentTop();
$mainContentBottom = createIndexContentBottom();
$sidebarTop = getSidebarTopModals();
$sidebarBottom = getSidebarBottomAd();

// Assemble Page
$masterPage = new MasterPage("Home");
$masterPage->setMainContentTop($mainContentTop);
$masterPage->setMainContentBottom($mainContentBottom);
$masterPage->setSidebarTop($sidebarTop);
$masterPage->setSidebarBottom($sidebarBottom);
$masterPage->renderPage();