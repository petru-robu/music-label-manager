# Music Label Manager

A PHP web application for managing music labels, artists, producers, and albums, built using a MySQL database and following the MVC architectural pattern.

**Branch:** `DEVELOPMENT`

---

## Project Overview

Music Label Manager is a dynamic, role-based web application that allows users to manage musical content, generate reports, analyze site activity, and interact through contact forms. The application is fully containerized with Docker and emphasizes security, scalability, and clean architecture.

---

## Requirements & Implementation

### 1. MySQL Database and PHP Backend

The project is developed in **PHP** and uses a **MySQL** relational database for data storage. 
All database interactions are handled through PDO for security and consistency.

Environment variables for database configuration are defined in the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=mydb
DB_USERNAME=myuser
DB_PASSWORD=mypass
```

---

### 2. CRUD Operations (Create, Read, Update, Delete)

The application supports full database operations:

- **Add** new users, artists, albums, and songs 
- **Read** and display records on dynamic pages 
- **Update** user profiles and content 
- **Delete** records with proper authorization 

These operations are implemented through Models in the MVC architecture.

---

### 3. User Authentication and Registration

The application provides:

- User registration page 
- Login/logout system 
- Secure password hashing 
- Session-based authentication 

Users must be authenticated to access protected routes.

---

### 4. Multiple User Roles

The system supports multiple user categories, each with specific permissions:

- **Listener** – browse content 
- **Artist** – manage own albums and songs 
- **Producer** – produce an artist's album
- **Admin** – manage and moderate users

Role-based access is enforced through middleware.

---

### 5. Dynamic Pages with Navigation

The application contains multiple dynamic pages such as:

- Dashboard 
- Artist pages 
- Album and song pages 
- Analytics pages 
- Admin panel

Pages are linked together through routing, and content is generated dynamically from the database.

---

### 6. Report Generation (PDF)

The system can generate downloadable **PDF reports** for users using the `setasign/fpdf` library.

Reports include:
- User general information
- Activity data

These reports are generated directly from controllers and are not limited to HTML or CSV formats.

---

### 7. Website Analytics and Statistics

The application tracks and displays:

- Total visits 
- Views per day 
- Most accessed pages 

Charts are generated using the `maantje/charts` library and rendered dynamically in the analytics dashboard.

---

### 8. Contact Form and Email Sending

A contact form allows users to send messages to the site administrator.

Email sending is implemented using **PHPMailer** with SMTP configuration:

```env
SMTP_USER=your_email@gmail.com
SMTP_PASS=your_app_password
CONTACT_RECEIVER_EMAIL=your_email@gmail.com
```

---

### 9. External Content Integration (Parsing)

The application integrates external information by parsing content from **Wikipedia** using cURL.

For example:
- Album information is fetched by giving a search query to wikipedia.
- The response is parsed and displayed inside the application.

This enriches the content without storing external pages.

---

### 10. Session Management and Logout

User sessions are managed using PHP sessions.

Features include:
- Session start on login 
- Role and user ID stored in session 
- Secure logout functionality that destroys the session and redirects users 

This ensures proper session ending and access control.

---

## Architecture

The project follows the **MVC (Model–View–Controller)** pattern:

- **Models** handle database logic. 
- **Views** render UI templates inside layouts. 
- **Controllers** process requests and return views. 

Routing and middleware manage navigation and access control.

---

## Setup

### Environment

```bash
cp .env.example .env
```

Update database and mail credentials as needed.

---

### Docker

Start the application:

```bash
sudo docker compose up -d --build
```

Stop the application:

```bash
sudo docker compose down
```

Containers:
- `musiclabel_mysql_db` – MySQL database 
- `musiclabel_apache` – PHP & Apache server

---

### Running DB Migrations

```bash
sudo docker exec -it musiclabel_apache /bin/bash
php app/Commands/migrate.php
```

---