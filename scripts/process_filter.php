<?php
require_once "../phone_comparison_site/api/bll.phone.php";
require_once "../phone_comparison_site/api/bll.phoneManager.php";
require_once "../page_assets/functions.php"; 
$phoneManager = new PhoneManager();
$phoneManager->loadPhones('../data/phones.json');
$phones = $phoneManager->getAllPhones();

$sortType = $_GET['sort'] ?? '';

if ($sortType === 'price') {
    usort($phones, function($a, $b) {
        return $a->price - $b->price;
    });
} elseif ($sortType === 'brand') {
    usort($phones, function($a, $b) {
        return strcmp($a->manufacturer, $b->manufacturer);
    });
} elseif ($sortType === 'rating') {
    usort($phones, function($a, $b) {
        return $b->customer_rating - $a->customer_rating;
    });
}

// Output the updated table rows
foreach ($phones as $phone) {
    echo "<tr>
            <td><img src='{$phone->image}' alt='{$phone->model}' style='width:60px; height:auto;'></td>
            <td>{$phone->model}</td>
            <td>{$phone->formatPrice()}</td>
            <td>{$phone->os}</td>
            <td>{$phone->manufacturer}</td>
            <td>" . renderStars($phone->customer_rating) . "</td> <!-- ⭐ ADD THIS PART -->
        </tr>";
}
?>