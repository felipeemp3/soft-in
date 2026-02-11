# Usamos la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalacion de extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiamos el código fuente de la aplicación al directorio raíz de Apache
COPY ./src /var/www/html/