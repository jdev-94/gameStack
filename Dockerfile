# 1. Usamos una imagen oficial de PHP con Apache incorporado
FROM php:8.2-apache

# 2. Instalamos extensiones necesarias para Laravel y herramientas de compresión
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# 3. Activamos el módulo de reescritura de Apache (vital para las rutas de Laravel)
RUN a2enmod rewrite

# 4. Cambiamos el directorio raíz de Apache para que apunte a /public de forma segura
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Copiamos los archivos del proyecto al servidor
COPY . /var/www/html

# 6. Instalamos Composer dentro del contenedor
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 7. Asignamos los permisos correctos a las carpetas de almacenamiento de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Exponemos el puerto estándar
EXPOSE 80