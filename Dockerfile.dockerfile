FROM php:8.2-apache

# Instalar extensiones necesarias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar el código de la aplicación
COPY . /var/www/html/

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Configurar Apache para usar el directorio 'web' de Yii2
RUN sed -i 's|/var/www/html|/var/www/html/web|g' /etc/apache2/sites-available/000-default.conf