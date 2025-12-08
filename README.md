# Music Label Manager

A web application for managing music labels, producers, and artists.

Branch: **DEPLOYMENT**

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

# Start containers in detached mode
sudo docker compose up -d
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
docker exec -it musiclabel_apache /bin/bash
```

#### Apache Virtual Host Configuration

```bash
# HTTP redirect to HTTPS
<VirtualHost *:80>
    ServerName petrucodes.ro
    ServerAlias www.petrucodes.ro
    Redirect permanent / https://petrucodes.ro/
</VirtualHost>

# HTTPS configuration
<VirtualHost *:443>
    ServerName petrucodes.ro
    ServerAlias www.petrucodes.ro

    DocumentRoot /var/www/html/public

    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/petrucodes.ro-0001/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/petrucodes.ro-0001/privkey.pem

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

### SSL Certificates

SSL certificates are generated using [Certbot](https://certbot.eff.org/) on the host. The host directory `/etc/letsencrypt` is bind-mounted into the container.

Generate certificates:

```bash
sudo certbot certonly --standalone -d petrucodes.ro -d www.petrucodes.ro
```

Certificates auto-renew every 3 months. The Apache virtual host configuration handles the domain and SSL setup.

**Tip:** Always back up your `.env` and database before making major changes.
