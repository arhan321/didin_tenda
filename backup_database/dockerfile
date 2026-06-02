# Use the official PHP image with Apache
FROM php:8.4-apache

# Set the working directory
WORKDIR /var/www/html

# Install required packages and PHP extensions
RUN apt-get update -y && apt-get install -y \
    libmariadb-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    zip \
    unzip \
    wget

# Configure and install GD extension separately to catch specific errors
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Install other PHP extensions
RUN docker-php-ext-install pdo_mysql mysqli mbstring exif zip pcntl bcmath calendar intl gettext opcache sockets

# Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure Apache
COPY httpd.vhost.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules and set permissions
RUN a2enmod rewrite && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Set "Require all granted" in vhost configuration
RUN sed -i 's/Require .*/Require all granted/' /etc/apache2/sites-available/000-default.conf

# Copy local code to the container
COPY . /var/www/html

# Expose port 80 for HTTP
EXPOSE 80

# Run Apache in the foreground
CMD ["apache2-foreground"]