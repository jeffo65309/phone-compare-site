<?php

// ===== PROFILEPAGE BUSINESS LOGIC (bll.profile.php) =====

// Profile picture and upload Proile upload doesnt work currently 
function createProfileTop($profilePic) {
    return <<<HTML
        <div class="text-center">
            <img src="{$profilePic}" alt="Profile Picture" class="img-thumbnail rounded-circle" style="width: 200px; height: 200px;" onerror="this.onerror=null;this.src='../assets/images/UsersImages/profilePlaceHolder.jpg';">
            <form action="../scripts/upload_profile_pic.php" method="POST" enctype="multipart/form-data" class="mt-2">
                <input type="file" name="profile_pic" class="form-control">
                <button type="submit" class="btn btn-primary btn-sm mt-2">Upload</button>
            </form>
        </div>
    HTML;
}

// Profile information 
function createProfileBottom($username, $name, $dob, $address, $bio, $favouritePhoneId, $phonesData) {
    $phoneOptions = '';

    foreach ($phonesData as $phone) {
        $selected = ($phone['id'] == $favouritePhoneId) ? 'selected' : '';
        $phoneOptions .= "<option value='{$phone['id']}' {$selected}>{$phone['manufacturer']} {$phone['model']}</option>";
    }

    return <<<HTML
    <div class="card p-4 mt-4">
        <h4 class="mb-3">Your Profile Info</h4>
        <form action="../scripts/process_updateProfile.php" method="POST">

            <div class="mb-3">
                <label class="form-label"><strong>Username</strong></label>
                <input type="text" name="username" class="form-control" value="{$username}" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Name</strong></label>
                <input type="text" name="name" class="form-control" value="{$name}" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Date of Birth</strong></label>
                <input type="date" name="dob" class="form-control" value="{$dob}">
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Address</strong></label>
                <input type="text" name="address" class="form-control" value="{$address}">
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Bio</strong></label>
                <textarea name="bio" class="form-control" rows="4" required>{$bio}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Favourite Phone</strong></label>
                <select name="favourite_phone" class="form-select">
                    <option value="">-- Select Your Favourite --</option>
                    {$phoneOptions}
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success w-50">Save Profile</button>
            </div>

        </form>
    </div>
    HTML;
}

// Email + Password change + Favourite phone
function createProfileSidebarTop($email, $favouritePhone, $phonesData) {
    if (is_null($phonesData) || !is_array($phonesData)) {
        return "<p>Error: Phone data not available.</p>";  // Handles error  if no data
    }

    $output = <<<HTML
        <h4>Account Settings</h4>
        <form action="../scripts/process_updateProfile.php" method="POST">
            <div class="form-group mb-2">
                <label class="form-label"><strong>New Email:</strong></label>
                <input type="email" name="new_email" class="form-control" value="{$email}" required>
            </div>
            <div class="form-group mb-2">
                <label class="form-label"><strong>New Password:</strong></label>
                <input type="password" name="new_password" class="form-control" placeholder="New Password">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update Settings</button>
        </form>
    HTML;

    $favouritePhoneDetails = null;
    if (!empty($favouritePhone)) {
        foreach ($phonesData as $phone) {
            if ($phone['id'] == $favouritePhone) {
                $favouritePhoneDetails = $phone;
                break;
            }
        }
    }

    if ($favouritePhoneDetails) {
        $output .= "<div class='text-center mt-4'>
            <h5>Your Favourite Smartphone ❤️</h5>
            <img src='{$favouritePhoneDetails['image']}' alt='{$favouritePhoneDetails['model']}' style='width:200px; height:auto;' class='img-thumbnail'>
            <p><strong>{$favouritePhoneDetails['manufacturer']} {$favouritePhoneDetails['model']}</strong></p>
        </div>";
    } else {
        $output .= "<p class='text-muted'>No favourite phone selected yet.</p>";
    }

    return $output;
}

// user reviews
function createProfileSidebarBottom($userId) {
    $reviews = json_decode(file_get_contents('../data/reviews.json'), true);
    $userReviews = array_filter($reviews, fn($r) => $r['user_id'] === $userId);

    $html = "<h4>Your Reviews</h4>";
    foreach ($userReviews as $review) {
        $html .= "<div>
            <strong>Rating:</strong> {$review['rating']} ⭐<br>
            <strong>Review:</strong> " . htmlspecialchars($review['comment']) . "<br>
            <small>{$review['timestamp']}</small>
        </div><hr>";
    }

    if (empty($userReviews)) {
        $html .= "<p class='text-muted'>You haven't submitted any reviews yet.</p>";
    }

    return $html;
}
?>