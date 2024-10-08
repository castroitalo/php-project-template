# Get PHP FPM
FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# Install Redis extensions
RUN pecl install redis && docker-php-ext-enable redis

# Copy PHP configuration file
COPY ./dev/php/config/php.ini /usr/local/etc/php/

# Setup composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# Copy app files to the container
COPY ./app .

# Get composer autoloader
RUN composer dump-autoload --optimize --no-dev

RUN php bin/execute_migrations.php

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g sass
