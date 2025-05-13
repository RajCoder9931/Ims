FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Copy all project files
COPY . /var/www/html/

WORKDIR /var/www/html
