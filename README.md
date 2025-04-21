# 🗂️ Task Management System

A Laravel-based task management system with an admin dashboard (Filament), Sanctum-powered API for user task operations, and a Vue.js frontend for users.

---

## 🚀 Features Implemented

- ✅ Admin panel to manage users and their tasks  
- ✅ Sanctum authentication for secure API access  
- ✅ CRUD APIs for tasks (Create, Read, Update, Delete)  
- ✅ Role distinction: Admin vs. regular user  
- ✅ Postman collection for testing all API endpoints  
- ✅ Vue.js powered frontend (user-side)  
- ✅ Filament-powered admin dashboard  

---

## 🛠 Setup Instructions

### 📋 Prerequisites

- PHP >= 8.2  
- Composer  
- Node.js & NPM  
- Laravel 11 or 12  
- MySQL  

---

### Accounts
- Admin Access:
- URL: /admin/login
- Email: manager@gmail.com
- Password: 123456789

- Default User:
- Email: taha@gmail.com
- Password: 123456789


### API Access
- All API routes are prefixed with /api
- Authenticated using Laravel Sanctum
- Postman Collection:
    - 🧪 View API Collection on Postman (https://api.postman.com/collections/18172464-4cb26b3c-bff1-47f5-8dbc-424c5a97be7b?access_key=PMAT-01JSC2WZYJD87CXMEWE3AD9K7N)


### ⚙️ Installation Steps

Clone the repository:
   ```bash
   git clone https://github.com/TahaAlaa/tms.git
   cd tms
   ```
   
Install PHP dependencies:
```bash
composer install
```

Install JS dependencies:
```bash
npm install 
npm run dev
```

Create .env file and set DB credentials:
```bash
cp .env.example .env
```


Create database named 'tms' , Configure DB in .env
```bash
DB_CONNECTION=sqlite  to  DB_CONNECTION=mysql
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tms
DB_USERNAME=root
DB_PASSWORD=
```

Generate application key:
```bash
php artisan key:generate
```

Run migrations:
```bash
php artisan migrate
```

Run seeder:
```bash
php artisan db:seed --class=UsersSeeder
```

Start development server:
```bash
php artisan serve
```

### Notes & Assumptions 
- Admin can view and manage all users and their tasks
- Users can manage only their own tasks via API
- Vue is used for user interaction
- Filament is used for admin dashboard
- Postman collection includes login and task operations
- Database must be migrated before using the system

### License
- This project is open-source and available under the MIT License.
