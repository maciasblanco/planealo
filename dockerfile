# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instala dependencias del sistema y extensiones de PHP necesarias para Yii2
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Instala extensiones de PHP requeridas
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación
COPY . .

# Instala las dependencias de Composer (sin scripts para evitar problemas de interacción)
RUN composer install --no-dev --no-interaction --no-plugins --no-scripts --prefer-dist

# Establece permisos adecuados para los directorios de Yii2
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/runtime \
    && chmod -R 755 /var/www/html/web/assets

# Expone el puerto 80
EXPOSE 80

# Comando por defecto (Apache se ejecuta en primer plano)
CMD ["apache2-foreground"]