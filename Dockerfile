FROM php:8.2-apache

# Set working directory inside the container
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libpq-dev \
        libzip-dev && \
    rm -rf /var/lib/apt/lists/*

# Install certbot
RUN apt-get update && \
    apt-get install -y certbot python3-certbot-apache

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files (production uses image, not bind-mounts)
COPY . /var/www/html

# Install PHP dependencies via Composer
RUN composer install --no-dev --optimize-autoloader

# Copy Apache configuration
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache rewrite module
RUN a2enmod rewrite

# Permissions (optional based on your needs)
RUN chown -R www-data:www-data /var/www/html




# # Start with a base PHP/Apache image
# FROM php:8.2-apache

# WORKDIR /app
# # 1. Install necessary dependencies (git, unzip, etc.)
# # 'apt-get update' must be run before 'apt-get install'
# RUN apt-get update && \
#     apt-get install -y \
#         git \
#         unzip \
#         libpq-dev \
#         libzip-dev

# # 2. Install PHP extensions
# RUN docker-php-ext-install pdo pdo_mysql zip

# # 3. Install Composer globally
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # --- Apache Configuration ---
# # 1. Copy a custom Apache config file to override the default DocumentRoot
# #    We will create this file next (000-default.conf)
# COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# # 2. Enable Apache rewrite module (essential for clean URLs)
# RUN a2enmod rewrite