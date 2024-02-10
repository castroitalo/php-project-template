# Debian with PHP 8.2 and Apache web server
FROM php:8.2-apache

# Apache configuration
COPY ./config/container/000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable apache rewriting
RUN a2enmod rewrite

# Update system and install basic packages
RUN apt update && \
    apt upgrade -y && \
    apt install libzip-dev -y && \
    apt install wget -y && \
    apt install unzip -y && \
    apt install vim -y

# Install PHP extensions
RUN docker-php-ext-install zip pdo_mysql

# PHP configuration file
COPY ./config/container/php.ini /usr/local/etc/php/

# Install composer
COPY ./config/container/install-composer.sh ./

RUN apt purge -y g++ \
    && apt autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/* \
    && sh ./install-composer.sh \
    && rm ./install-composer.sh

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Root work directory
WORKDIR /var/www/html/public

# Start apache with container
CMD [ "apache2-foreground" ]
