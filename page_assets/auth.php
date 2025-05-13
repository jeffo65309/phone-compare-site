<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'functions.php'; 
define('USER_DATA_FILE', __DIR__ . '/../data/users.json');



// REGISTER
if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $username = safeInput($_POST['username']);
    $email = safeInput($_POST['email']);
    $password = $_POST['password'];

    //  Validate fields
    if (!validateEmail($email)) {
        $_SESSION['error'] = 'Invalid email format!';
        header('Location: /Phone_CompareSite/phone_comparison_site/index.php');
        exit();
    }

    if (!validatePassword($password)) {
        $_SESSION['error'] = 'Password must be at least 6 characters!';
        header('Location: /Phone_CompareSite/phone_comparison_site/index.php');
        exit();
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $users = loadUsers();

    // Check for duplicates
    foreach ($users as $user) {
        if ($user['username'] === $username || $user['email'] === $email) {
            $_SESSION['error'] = 'Username or email already exists!';
            header('Location: /Phone_CompareSite/phone_comparison_site/index.php');
            exit();
        }
    }

    // Create new user
    $users[] = [
        'id' => count($users) + 1,
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'saved_phones' => [],
        'name' => '',
        'address' => '',
        'dob' => '',
        'bio' => '',
        'profile_pic' => ''
    ];

    saveUsers($users);
    $_SESSION['success'] = 'Registration successful! Please log in.';
    header('Location: /Phone_CompareSite/phone_comparison_site/profile.php');
    exit();
}


// LOGIN
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = safeInput($_POST['username']);
    $password = $_POST['password'];

    $users = loadUsers();

    foreach ($users as $user) {
        if (
            (strtolower($user['username']) === strtolower($username) || strtolower($user['email']) === strtolower($username)) &&
            password_verify($password, $user['password'])
        ) {
            $_SESSION['user'] = $user;

            // Set the success flash on login
            $_SESSION['success'] = 'Login successful!';

            // Check if profile is complete
            if (empty($user['name']) || empty($user['bio'])) {
                header('Location: /Phone_CompareSite/phone_comparison_site/profile.php');
                exit();
            } else {
                header('Location: /Phone_CompareSite/phone_comparison_site/index.php');
                exit();
            }
        }
    }

    $_SESSION['error'] = 'Invalid username or password!';
    header('Location: /Phone_CompareSite/phone_comparison_site/index.php');
    exit();
}


// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /Phone_CompareSite/phone_comparison_site/login.php');
    exit();
}
?>