# 📱 Phone Comparison Website (PHP)

This is a PHP-based phone comparison website developed for a university assignment. It allows users to register and log in, view and compare phones, leave reviews, and filter/search by different features.

---

## ✅ Features

- 🔐 **Secure Login & Registration**
  - Password hashing and validation
  - Session-based authentication

- 📦 **JSON-Based Data**
  - Phone data and user reviews stored in local `.json` files

- ⭐ **Review & Rating System**
  - Users can rate and review phones
  - Reviews tied to user accounts

- 🔍 **Filtering & Search**
  - Filter by price, brand, and rating
  - AJAX-style dynamic filtering

- 🧠 **Clean Layout**
  - Bootstrap interface with modals and dynamic content
  - Master page system for consistent layout across all pages

---

## 📁 Project Structure

```
/Phone_CompareSite
├── /phone_comparison_site
│ ├── index.php
│ ├── phone.php
│ ├── profile.php
│ ├── login.php / register.php
│ ├── /api
│ ├── /data (phones.json, users.json, reviews.json)
│ ├── /page_assets (masterPage.php, styles)
│ └── /scripts (filtering, login logic, review handling)
```


---

## 🛠 How to Run Locally

1. Make sure you have **PHP installed** (e.g. via XAMPP, WAMP or PHP CLI)
2. Copy the folder into your local web server directory (e.g. `htdocs`)
3. Start your local server (Apache)
4. Open your browser and go to:
```
http://localhost/Phone_CompareSite/phone_comparison_site/index.php
```


---

## 📌 Notes

- This project is fully offline — no external database required.
- JSON is used for simplicity in a learning environment.
- Great for showing PHP logic, sessions, and modular layout using `MasterPage`.

---

## 👤 Author

**Jefferey Slaven**  
1st Year BSc Cyber Security Student  
GitHub: [@jeffo65309](https://github.com/jeffo65309)

