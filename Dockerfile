FROM php:8.2-apache

# Install system dependencies including Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    nodejs \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions using the official installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo_mysql mongodb bcmath

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Update Apache document root to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configure Apache to listen on PORT environment variable (for Render)
RUN sed -i 's/Listen 80/Listen ${PORT:-80}/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:${PORT:-80}/g' /etc/apache2/sites-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Node modules and build Vite assets
RUN npm install
RUN npm run build

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start Apache
CMD ["apache2-foreground"]
