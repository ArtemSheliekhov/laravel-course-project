<p align="center">
  <a href="https://github.com/ArtemSheliekhov/laravel-course-project" target="_blank">
   <img width="436" height="153" alt="image" src="https://github.com/user-attachments/assets/7b7c6952-2b45-485e-aec9-2403407da312" />
  </a>
</p>

<p align="center">
  <a href="https://laravel.com">
    <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  </a>
  <a href="https://laravel.com/docs/starter-kits#laravel-breeze">
    <img src="https://img.shields.io/badge/Laravel_Breeze-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Breeze">
  </a>
  <a href="https://www.php.net">
    <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  </a>
  <a href="https://www.mysql.com">
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  </a>
  <a href="https://fullcalendar.io">
    <img src="https://img.shields.io/badge/FullCalendar-3766AB?style=for-the-badge&logo=fullcalendar&logoColor=white" alt="FullCalendar">
  </a>
  <a href="https://getbootstrap.com">
    <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge" alt="License">
  </a>
</p>

# Appointment/Booking System 

A full-stack web application for managing appointments, services, and business analytics with interactive calendar interface.

https://github.com/user-attachments/assets/ece8bf8b-4eff-4c00-a9c3-07407e9117da

## 📅 Core Functionality

### 1. Appointment Management
- **CRUD Operations**:
  - Create appointments with service linking
  - Update existing bookings
  - Soft delete functionality

### 2. User System
- **Laravel Breeze Auth**:
  - Email verification
  - Password reset
- **User Profiles**:
  - Service preferences
  - Appointment history

### 3. Business Analytics
- **Dashboard**:
  - Appointment volume trends
  - Service popularity
  - Revenue projections

## 🛠️ Technical Stack

### Backend Services
- **Laravel**
  - MVC architecture with service layer
  - RESTful API endpoints
  - CSRF protection
- **Database**:
  - MySQL
  - Data binding

### Frontend Application
- **JavaScript/jQuery**
  - AJAX form submissions
  - Dynamic content loading
  - Real-time validation
- **UI Components**:
  - Bootstrap 
  - FullCalendar 
  - Custom dashboard widgets

### Development Prerequisites
- **Environment**:
  - PHP 
  - Composer 
  - Node.js

## 💻 Installation

```bash
git clone https://github.com/ArtemSheliekhov/laravel-course-project.git
cd laravel-course-project
composer install
breeze install
npm install

# Configure .env file
cp .env.example .env

# Run migrations
php artisan migrate --seed

# Start development server
php artisan serve
```

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## 📜 License

[MIT](https://choosealicense.com/licenses/mit/)
