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

# Enable Apache modulessudo 
RUN a2enmod rewrite ssl

# Permissions (optional based on your needs)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose ports for HTTP and HTTPS
EXPOSE 80 443