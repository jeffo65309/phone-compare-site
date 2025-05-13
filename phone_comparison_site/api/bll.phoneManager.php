<?php

// ===== BUSINESS LOGIC (bll.phoneManager.php) =====

class PhoneManager {
    private $phones = [];

    // Load phones from a JSON file
    public function loadPhones($jsonFile) {
        $jsonData = file_get_contents($jsonFile);
        $phonesArray = json_decode($jsonData, true);
        
        foreach ($phonesArray as $phoneData) {
            $this->phones[] = new Phone(
                $phoneData['id'],
                $phoneData['model'],
                $phoneData['price'],
                $phoneData['os'],
                $phoneData['manufacturer'],
                $phoneData['image'],
                $phoneData['release_date'],
                $phoneData['screen_size'],
                $phoneData['resolution'],
                $phoneData['cameras'],
                $phoneData['weight'],
                $phoneData['battery'],
                $phoneData['processor'],
                $phoneData['storage'],
                $phoneData['customer_rating']
            );
        }
    }

    // Get all phones
    public function getAllPhones() {
        return $this->phones;
    }

    // Sort phones by price (ascending)
    public function sortPhonesByPrice() {
        usort($this->phones, function($a, $b) {
            return $a->price <=> $b->price;
        });
    }

    // Sort phones by rating (descending)
    public function sortPhonesByRating() {
        usort($this->phones, function($a, $b) {
            return $b->customer_rating <=> $a->customer_rating;
        });
    }

    // Find a phone by its ID
    public function getPhoneById($id) {
        foreach ($this->phones as $phone) {
            if ($phone->id == $id) {
                return $phone;
            }
        }
        return null; 
    }
}