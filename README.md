# Alumni Influencers Platform

A RESTful web API and analytics dashboard built with CodeIgniter 3 and MySQL.

## Requirements
- PHP 8.x
- MySQL 8.x
- XAMPP
- Composer

## Setup

1. Clone the repository
2. Run `composer install` from the project root
3. Create a MySQL database called `alumni_db`
4. Import `schema.sql` into the database via phpMyAdmin
5. Copy `.env.example` to `.env` and fill in your SMTP credentials
7. Update `application/config/database.php` to set your MySQL credentials
8. Start PHP server with
9. Visit `http://localhost:8080/login.html`

## Environment Variables

See `.env.example` for required variables.

## API Documentation

Swagger UI is available at `/api-docs/index.html`.