<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); //remove when finished

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



require_once "../page_assets/masterPage.php";
require_once "../page_assets/functions.php";
require_once "../phone_comparison_site/api/bll.profile.php"; 



// redirects if user not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$masterPage = new MasterPage("Your Profile");

$flashMessages = getFlashMessages();

// user data
$user = $_SESSION['user'];

$phonesData = $masterPage->getPhonesData(); 


// Build Page Sections using BLL
$mainContentTop = createProfileTop($user['profile_pic'] ?? '../assets/images/UsersImages/profilePlaceHolder.jpg');
$mainContentBottom = createProfileBottom(
    $user['username'] ?? '', 
    $user['name'] ?? '', 
    $user['dob'] ?? '', 
    $user['address'] ?? '', 
    $user['bio'] ?? '', 
    $user['favourite_phone'] ?? '', 
    $phonesData
);
$sidebarTop = createProfileSidebarTop($user['email'] ?? '', $user['favourite_phone'] ?? '', $phonesData);
$sidebarBottom = createProfileSidebarBottom($user['id']);

// Assemble Page

$masterPage->setMainContentTop($flashMessages . $mainContentTop); 
$masterPage->setMainContentBottom($mainContentBottom);
$masterPage->setSidebarTop($sidebarTop);
$masterPage->setSidebarBottom($sidebarBottom);
$masterPage->renderPage();
?>