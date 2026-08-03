FROM php:8.2-apache

# install extension sistem dan PostGresql
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql zip

# enable Apache Mod rewrite
RUN a2enmod rewrite

# ubah DocumentRoot Apache ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# set working directory
WORKDIR /var/www/html

# copy source code ke container
COPY . .

# INSTALL COMPOSER
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# set permission folder storage & bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# port default Render
EXPOSE 80

# jalankan apache di foreground
CMD ["apache2-foreground"]