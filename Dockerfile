# Use the official PHP image with Apache web server
FROM php:8.1-apache

# Copy the bot's PHP file into the web server's root directory
COPY index.php /var/www/html/index.php
