<?php

require_once("../page_assets/functions.php");

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Make sure user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Load users
$userFile = '../data/users.json';
$users = json_decode(file_get_contents($userFile), true) ?? [];
$currentUsername = $_SESSION['user']['username'] ?? '';
$updated = false;

// Find the logged in user
foreach ($users as &$user) {
    if ($user['username'] === $currentUsername) {

        // Update fields 
        $fieldsToUpdate = [
            'username',
            'name',
            'dob',
            'address',
            'bio',
            'favourite_phone'
        ];

        foreach ($fieldsToUpdate as $field) {
            if (isset($_POST[$field])) {
                $user[$field] = safeInput($_POST[$field]);
                $updated = true;
            }
        }

        // email and password
        if (!empty($_POST['new_email'])) {
            $user['email'] = safeInput($_POST['new_email']);
            $updated = true;
        }

        if (!empty($_POST['new_password'])) {
            $user['password'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $updated = true;
        }

        break; 
    }
}

// Save changes
if ($updated) {
    file_put_contents($userFile, json_encode($users, JSON_PRETTY_PRINT));
    $_SESSION['user'] = $user;
    $_SESSION['success'] = "Profile updated successfully!"; 
}

// Redirect back to profile page
header("Location: /Phone_CompareSite/phone_comparison_site/profile.php");
exit();
?>