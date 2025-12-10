A mini CRM built using Laravel with:
Authentication & Roles
Customer Management
Order Management
API with Sanctum Authentication
PDF & CSV Export

Installation Steps:
1. Clone the Repository
git clone https://github.com/purabkhona/impactguru-crm.git
cd impactguru-crm

2. Install PHP & Node Dependencies
composer install
npm install

3. Setup Environment File
cp .env.example .env
php artisan key:generate

Now open .env and update database settings:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=impactguru_crm
DB_USERNAME=root
DB_PASSWORD=

4. Create Database & Import Data

Open phpMyAdmin

Create database:
impactguru_crm

Import:
impactguru_crm.sql

5. Run Remaining Migrations (If Any)
php artisan migrate

6. Build Frontend Assets
npm run dev

7. Run Laravel Server
php artisan serve


Open in browser:

http://127.0.0.1:8000

8. Admin Login Credentials
Email: admin@example.com
Password: Admin@123
Role: Admin

9. API Login (Postman)
POST http://127.0.0.1:8000/api/login

Body -> raw-> (JSON): 

{
  "email": "admin@example.com",
  "password": "password"
}


**Feature List:-**
User Authentication (Login & Logout)
Role-Based Access Control (Admin & Staff)
Customer Management (CRUD)
Add Customer
View Customers
Edit Customer
Delete Customer
Order Management (CRUD)
Create Orders
View Orders
Update Orders
Delete Orders
API Authentication using Laravel Sanctum (Token Based)
Customer API Endpoints (Protected)
Order API Endpoints (Protected)
CSV Export for Customers & Orders
PDF Export for Customers & Orders
Form Request Validation for Clean Input Handling
Proper Error Handling with Validation Messages
Custom 404 & 500 Error Pages
Application Error Logging (storage/logs/laravel.log)
Secure Database Sessions
Responsive UI using Tailwind CSS
RESTful API Architecture
Postman API Testing Support

**Role Permissions Summary:-**

Admin Role:
Can access Dashboard
Can add, view, edit, and delete Customers
Can add, view, edit, and delete Orders
Can export Customers & Orders (PDF & CSV)
Can access all protected API routes
Can update and delete customer data via API
Full system control

Staff Role:
Can view Customers
Can add new Customers
Can view Orders
Cannot delete Customers
Cannot delete Orders
Cannot access sensitive admin APIs
