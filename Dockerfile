# 1. Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# 2. Instalamos extensiones necesarias (¡Añadimos curl para tus peticiones a la API de RAWG!)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libcurl4-openssl-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql curl

# 3. Activamos el módulo de reescritura de Apache
RUN a2enmod rewrite

# 4. Cambiamos el directorio raíz de Apache a /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Copiamos los archivos del proyecto al servidor
COPY . /var/www/html

# 6. Instalamos Composer dentro del contenedor
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Otorgamos la propiedad de los archivos al usuario de Apache
RUN chown -R www-data:www-data /var/www/html

# 8. Ejecutamos composer install como el usuario www-data
USER www-data
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 9. Volvemos al usuario raíz para la ejecución de Apache
USER root

# 10. En lugar de cachear en el build, dejamos que se limpie la caché dinámicamente al arrancar el contenedor
CMD ["sh", "-c", "php artisan config:clear && php artisan view:clear && apache2-foreground"]

# 11. Exponemos el puerto estándar
EXPOSE 80