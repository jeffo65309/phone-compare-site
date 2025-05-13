<?php

// ===== RANKINGPAGE BUSINESS LOGIC (bll.ranking.php) =====

function createRankingContentTop($phones) {
    $tableRows = '';
    foreach ($phones as $phone) {
        $tableRows .= "<tr>
            <td><img src='{$phone->image}' alt='{$phone->model}' style='width:60px; height:auto;'></td>
            <td>{$phone->model}</td>
            <td>{$phone->formatPrice()}</td>
            <td>{$phone->os}</td>
            <td>{$phone->manufacturer}</td>
            <td>" . renderStars($phone->customer_rating) . "</td> <!-- star function here -->
        </tr>";
    }

    return <<<HTML
        <h2>Phone Rankings</h2>
        <p>See which phones are trending and have the best reviews.</p>

        <!--Filter dropdown -->
        <div class="mb-3">
            <label for="filterSelect" class="form-label">Sort By:</label>
            <select id="filterSelect" class="form-select w-auto">
                <option value="">-- Select --</option>
                <option value="price">Price (Low to High)</option>
                <option value="brand">Brand (A-Z)</option>
                <option value="rating">Customer Rating</option>
            </select>
        </div>

        <table class='table table-striped'>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>OS</th>
                    <th>Manufacturer</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody id="phoneTableBody">
                {$tableRows}
            </tbody>
        </table>
    HTML;
}

function createRankingContentBottom($phones, $recommendations) {
    $output = "<h3>My Personal Phone Recommendations</h3><p>These are my honest takes on the best phones right now:</p>";

    foreach ($phones as $phone) {
        if (isset($recommendations[$phone->id])) {
            $output .= <<<HTML
            <div class="card mb-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-4 text-center">
                        <img src="{$phone->image}" class="img-fluid rounded-start" alt="{$phone->model}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title">{$phone->manufacturer} {$phone->model}</h4>
                            <p><strong>Customer Rating:</strong> {$phone->customer_rating} / 5</p>
                            <p><strong>My Thoughts:</strong> {$recommendations[$phone->id]}</p>
                        </div>
                    </div>
                </div>
            </div>
            HTML;
        }
    }

    return $output;
}


function createRankingSidebarTop($favouritePhone, $phonesData) {
    $output = ''; 

    $favouritePhoneDetails = null;
    if (!empty($favouritePhone)) {
        foreach ($phonesData as $phone) {
            if ($phone['id'] == $favouritePhone) {
                $favouritePhoneDetails = $phone;
                break;
            }
        }
    }

    // Build users favourite phone display
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

function createRankingSidebarBottom() {
    $extraPath = __DIR__ . '/../../content/phone_salesInfo.html';

    if (file_exists($extraPath)) {
        return '<div class="p-3 border rounded bg-light mt-4">' . file_get_contents($extraPath) . '</div>';
    } else {
        return '<p class="text-danger">Deals content could not be loaded.</p>';
    }
}