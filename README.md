# Music Label Manager

A web application for managing music labels, producers, and artists.

Branch: **DEVELOPMENT**

## Description
The application should have an interface for artists to add new songs / albums.

## Setup
### Environment Variables

After cloning the repository, create your `.env` file:

```bash
cp .env.example .env
```

`.env.example` contains database configuration:

```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=mydb
DB_USERNAME=myuser
DB_PASSWORD=mypass
DB_SSL_MODE=DISABLED
```

> Note: Environment variables can be overridden by those defined in `docker-compose.yml`. Be careful when making changes.

### Docker

The application is fully containerized using Docker.

* `docker-compose.yml` defines containers, networks, and volumes.
* `Dockerfile` sets up PHP and Apache, configures permissions, and exposes the necessary ports.

This setup uses two containers:

* **MySQL Database:** `musiclabel_mysql_db`
* **PHP/Apache:** `musiclabel_apache`

#### Start/Stop the Application

```bash
# Stop and remove containers
sudo docker compose down

# Start containers and rebuild in detached mode
sudo docker compose up -d --build
```

#### Useful Docker Commands

```bash
# List all containers
sudo docker ps -a

# Stop specific containers
sudo docker stop musiclabel_apache musiclabel_mysql_db

# Remove specific containers
sudo docker rm -f musiclabel_apache musiclabel_mysql_db
```

### MySQL Database

Access the MySQL container:

```bash
sudo docker exec -it musiclabel_mysql_db mysql -u root -prootpass
```

Common MySQL commands inside the container:

```sql
SHOW DATABASES;          -- List all databases
USE mydb;                -- Select a database
CREATE DATABASE db_name; -- Create a new database
DROP DATABASE db_name;   -- Delete a database
SHOW TABLES;             -- List tables
DESCRIBE table_name;     -- Show table structure
DROP TABLE table_name;   -- Delete a table
SELECT * FROM table_name;-- Query all records
EXIT;                    -- Exit MySQL
```

### Apache Web Server

Access the Apache container:

```bash
sudo docker exec -it musiclabel_apache /bin/bash
```

#### Apache Virtual Host Configuration
A simple apache configuration for running locally.
```bash
<VirtualHost *:80>
# 1. Set the Document Root to the public folder (the only public-facing directory)
DocumentRoot /app/public

<Directory /app/public>
    # Allow .htaccess files to override settings
    AllowOverride All
    # Require all users to access this directory
    Require all granted
</Directory>

# Log file locations
ErrorLog ${APACHE_LOG_DIR}/error.log
CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

### Running migrations

To run a migration you need to:

Enter the docker container:
```bash
sudo docker exec -it musiclabel_apache /bin/bash
```

Run the php file to apply everything in the migrations folder:
```bash
php app/Commands/migrate.php

```