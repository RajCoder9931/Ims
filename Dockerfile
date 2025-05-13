FROM php:8.1-apache

# Enable mod_rewrite if needed
RUN a2enmod rewrite

# Copy all files into Apache's root folder
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html
