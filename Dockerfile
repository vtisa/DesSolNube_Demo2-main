FROM php:8.1-apache
#instalar depencias necesaria para postsgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_pgsql

#copiar contenido de toda la app en mi contenedor
COPY . /var/www/html/

# Expone el puerto 80
EXPOSE 80