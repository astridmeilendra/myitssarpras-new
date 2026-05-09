FROM php:8.2-apache

# Install dependencies dan extension PHP
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev \
    zip unzip git curl nodejs npm

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . .

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# PENTING: Jalankan build aset Vite (karena package.json kamu pakai vite)
RUN npm install
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Konfigurasi Apache ke folder /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

ENV PORT=8080
EXPOSE 8080

CMD ["apache2-foreground"]