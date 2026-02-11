FROM php:8.2-apache

# Instalamos las extensiones de base de datos
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiamos tu código a la carpeta del servidor
COPY ./src /var/www/html/