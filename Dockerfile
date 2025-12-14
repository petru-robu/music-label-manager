# Start with a base PHP/Apache image
FROM php:8.2-apache

WORKDIR /app
# 1. Install necessary dependencies (git, unzip, etc.)
# 'apt-get update' must be run before 'apt-get install'
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libfreetype6-dev \
        libpq-dev \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev

# 2. Install PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# 3. Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# --- Apache Configuration ---
# 1. Copy a custom Apache config file to override the default DocumentRoot
#    We will create this file next (000-default.conf)
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# 2. Enable Apache rewrite module (essential for clean URLs)
RUN a2enmod rewrite