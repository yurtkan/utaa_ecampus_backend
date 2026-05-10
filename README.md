<div align="center">

# UTAA eCampus Backend API

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![REST API](https://img.shields.io/badge/REST-API-FF6F00?style=for-the-badge&logo=api&logoColor=white)](#)
[![License: CC BY-NC 4.0](https://img.shields.io/badge/License-CC%20BY--NC%204.0-lightgrey.svg?style=for-the-badge)](https://creativecommons.org/licenses/by-nc/4.0/)

*The core RESTful backend service powering the official **UTAA eCampus** mobile application.*

</div>

---

## 📖 Overview

The **UTAA eCampus Backend** is a custom-built, lightweight PHP-based REST API designed specifically to serve the data requirements of the UTAA (University of Turkish Aeronautical Association) eCampus application. It follows a clean MVC (Model-View-Controller) pattern to efficiently route requests, process business logic, and interact with the underlying MySQL database.

This API handles crucial campus information, including user authentication, academic calendars, daily meal menus, shuttle (ring) schedules, official notices, and course management.

**Repository URL:** [https://github.com/yurtkan/utaa_ecampus_backend](https://github.com/yurtkan/utaa_ecampus_backend)

---

## ✨ Key Features

- **User Authentication:** Secure endpoints for user login, registration, and profile management.
- **Academic & Course Management:** Retrieve course lists, schedules, and academic calendars dynamically.
- **Campus Life Integration:** Real-time access to daily cafeteria meal menus and campus shuttle (ring) schedules.
- **Announcements & Notices:** Centralized endpoint for fetching university-wide notices and important alerts.
- **Contact & Support:** Built-in contact form routing and processing.
- **Lightweight Architecture:** Pure PHP implementation without heavy framework overhead, ensuring fast response times and easy deployment.
- **Standardized REST Responses:** Consistent JSON response formatting for seamless mobile app integration.

---

## 🗂️ Project Structure

The project is structured around a custom MVC architecture for maximum clarity and separation of concerns.

```text
utaa_ecampus_backend/
├── api/
│   ├── Controller/
│   │   └── Api/
│   │       ├── BaseController.php      # Core controller providing base JSON response utilities
│   │       ├── CalendarController.php  # Handles academic calendar requests
│   │       ├── ContactController.php   # Manages support/contact form submissions
│   │       ├── CourseController.php    # Manages course information and schedules
│   │       ├── MealController.php      # Fetches daily cafeteria menus
│   │       ├── NoticeController.php    # Retrieves campus announcements
│   │       ├── RingController.php      # Handles shuttle (ring) timetables
│   │       └── UserController.php      # Manages user authentication and profiles
│   ├── inc/
│   │   ├── bootstrap.php               # Initializes app, defines constants, and auto-includes dependencies
│   │   └── config.php                  # Database connection credentials (DO NOT COMMIT to public repos)
│   ├── Model/
│   │   ├── CalendarModel.php           # Database interactions for the calendar
│   │   ├── CourseModel.php             # Database interactions for courses
│   │   ├── MealModel.php               # Database interactions for meals
│   │   ├── NoticeModel.php             # Database interactions for notices
│   │   ├── RingModel.php               # Database interactions for shuttles
│   │   └── UserModel.php               # Database interactions for user accounts
│   └── index.php                       # Central API Router (Entry point for all requests)
├── LICENSE                             # CC BY-NC 4.0 License file
└── README.md                           # Project documentation (You are here)
```

---

## 🚀 Getting Started

Follow these instructions to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- A web server running **PHP** (e.g., Apache, Nginx, XAMPP, or MAMP).
- A **MySQL** or **MariaDB** database server.
- Basic knowledge of RESTful APIs.

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yurtkan/utaa_ecampus_backend.git
   cd utaa_ecampus_backend
   ```

2. **Configure the Database Connection:**
   Navigate to the `api/inc/` directory and open the `config.php` file (create it if it doesn't exist). Update the credentials to match your local or production database environment.
   ```php
   <?php
       define("DB_HOST", "localhost");
       define("DB_USERNAME", "your_db_username");
       define("DB_PASSWORD", "your_db_password");
       define("DB_DATABASE_NAME", "your_db_name");
   ?>
   ```

3. **Configure SMTP (Optional but Recommended):**
   If you intend to use email features (e.g., in the Contact or User controllers), ensure you provide the necessary SMTP configuration directly within the relevant Controller files or extend `config.php` to handle email credentials securely.

4. **Set Up Routing / Server:**
   Ensure your web server routes requests correctly to the `api/index.php` file. The API expects URLs in the following format:
   ```text
   https://yourdomain.com/utaa_ecampus_backend/api/index.php/{controller}/{action}
   ```
   *Example: `.../api/index.php/user/login`*

---

## ⚖️ License

This project is licensed under the **Creative Commons Attribution-NonCommercial 4.0 International License (CC BY-NC 4.0)**. 

Please see the [LICENSE](LICENSE) file for the full, detailed legal code.

### Summary of License Terms

By using this software, you agree to the following terms explicitly enforced by the author:

> [!NOTE]
> **1. Personal, Educational, and Fair Use Allowed:**
> You are free to use, copy, modify, and distribute this software for personal, educational, academic, and non-commercial fair use purposes.

> [!WARNING]
> **2. Strictly No Commercial Use:**
> You may **NOT** use this software, or any part of its source code, for any commercial purpose (e.g., selling the software, using it in an enterprise environment, or monetizing it via ads/subscriptions). Any commercial use, reuse, or monetization strictly requires purchasing a separate commercial license from the original author.

> [!IMPORTANT]
> **3. Proper Attribution Required:**
> You must give appropriate credit to the original author, provide a link to the license, and indicate if any changes were made.
