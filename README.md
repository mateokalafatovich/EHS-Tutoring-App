# EHS Tutoring App

A web-based platform designed to simplify and enhance the connection between tutors and students at Eastlake High School.

---

##  Project Description

The **EHS Tutoring App** aims to create a centralized system where students can request tutoring assistance and tutors can manage and respond to those requests efficiently. Built with PHP, HTML, CSS, and JavaScript, this application incorporates database functionality and dynamic user interface elements. It is adapted from an existing project template and customized to fit the needs of the EHS community.

---

##  Tech Stack & Structure

- **Backend:** PHP  
- **Frontend:** HTML, CSS, JavaScript (with structured folders for CSS, JS, and webfonts)  
- **Database:** MySQL or similar relational database (as included in the `/database` directory)  
- **Template Source:** Adapted from [configuroweb/matriculas] — customized and restructured for this project

---

## Prerequisites
- **XAMPP** (PHP + MySQL) or another PHP server with MySQL support  
- Git (optional, for cloning the repo)  

---

## Setup Instructions

### 1. Download the Project
- **Option 1 — Git:**
```bash
cd /path/to/htdocs
git clone https://github.com/mateokalafatovich/EHS-Tutoring-App.git
```
- Option 2 — ZIP:

1. Download ZIP from GitHub repo

2. Extract into your server’s htdocs folder (e.g., C:\xampp\htdocs\EHS-Tutoring-App)

### 2. Start Your Server

- Launch XAMPP Control Panel

- Start Apache and MySQL

### 3. Setup the Database

1. Open phpMyAdmin

2. If a database named student already exists, drop it to avoid duplicate entries

3. Import the SQL file located at:

```bash
EHS-Tutoring-App/database/EHS Tutor Database.sql
```

- This will create the student database, tables, and populate sample data

### 4. Configure Database Connection

1. Open admin/db_con.php

2. Update the connection details to match your server:

```bash
define('DBHOST', 'localhost');  // Database host
define('DBUSER', 'root');       // Default MySQL user
define('DBNAME', 'student');    // Database name
$db_con = mysqli_connect(DBHOST, DBUSER, '', DBNAME); // MySQL password (XAMPP default is empty)
```

### 5. Launch the App

- Open your browser:

    - Main site: http://localhost/EHS-Tutoring-App/

- Log in with sample users from the database (e.g., configuroweb, usuario1)

### 6. Troubleshooting

- Database connection errors: check db_con.php settings and ensure MySQL is running

- Duplicate entries on import: drop the existing student database and re-import the SQL file

- Apache or MySQL not starting: ensure no other program is using ports 80 or 3306

---

## Folder Structure

```bash
EHS-Tutoring-App/
│
├── admin/              # Admin panel and database connection
│   └── db_con.php
├── database/           # SQL file to create database
├── css/                # Stylesheets
├── js/                 # JavaScript files
├── uploads/            # Student photos
└── index.php           # Main landing page
```

### Acknowledgments

Starter template derived from **[configuroweb/matriculas](https://github.com/configuroweb/matriculas)**.
