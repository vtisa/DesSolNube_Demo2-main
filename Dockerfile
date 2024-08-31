FROM php:8.1-apache

# Instala las dependencias necesarias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# Copia el contenido de tu aplicacion en el contenedor
COPY . /var/www/html/

# Expone el puerto 80
EXPOSE 80
