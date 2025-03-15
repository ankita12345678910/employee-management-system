# Employee Management System
## Requirements
- PHP **8.1** or later
- Composer
- MySQL or any supported database
- XAMPP (optional, for local development)

## Installation

### 1. Clone the Repository
```sh
git clone https://github.com/repository/employee-management-system.git
cd employee-management-system
```

### 2. Install Dependencies
Run the following command to install PHP dependencies:
```sh
composer install
```

### 3. Create Database in MySql
Run the following query in mysql:
```sh
CREATE DATABASE your_database_name;
```
### 4. Configure the Environment
update the database settings in the `.env` file:
```env
database.default.hostname = localhost
database.default.database = your_database_name (eg- 'emp_management')
database.default.username = your_database_user (eg- 'root')
database.default.password = your_database_password (eg- '')
database.default.DBDriver = MySQLi
```

### 5. Run Migrations & Seeders
Run the database migrations:
```sh
php spark migrate
```
Seed the database with default employees:
```sh
php spark db:seed EmployeeSeeder
```

### 6. Start the Development Server
```sh
php spark serve
```
Then open the browser and go to:
```
http://localhost:8080/
```
### 7. Login Credential at Initial
Username: employee@1
Password: employee1

## Usage
1. **Login:** Access the login page at `/`.
2. **Manage Employees:** Add, update, or delete employees.
3. **Logout:** Securely end the session.