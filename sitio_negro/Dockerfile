FROM php:8.2-apache

# Instala extensiones necesarias para conectarse a MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Copia permisos correctos
RUN chown -R www-data:www-data /var/www/html