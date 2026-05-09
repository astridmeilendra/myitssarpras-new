FROM php:8.2-apache

# Install extension PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Aktifkan mod_rewrite Apache untuk Laravel
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy file project
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions untuk Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ubah port Apache ke 8080 (sesuai standar Cloud Run)
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Env vars
ENV PORT=8080
EXPOSE 8080

CMD ["apache2-foreground"]