# Usa una imagen base de PHP con Apache
FROM php:7.4-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip git

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar el módulo mod_rewrite de Apache (para manejar URLs amigables)
RUN a2enmod rewrite

# Copiar el archivo de configuración de Apache
COPY ./config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Configuración de la carpeta de trabajo
WORKDIR /var/www/html
