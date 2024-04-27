# Debian with PHP 8.2 and Apache web server
FROM php:8.2-apache

# Apache configuration
COPY ./config/container/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./config/container/apache/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

# Enable apache modules
RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2ensite default-ssl

# Create self-signed SSL certificate
RUN mkdir /etc/apache2/ssl && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/localhost.key -out /etc/apache2/ssl/localhost.crt -subj "/C=BR/ST=Denial/L=Sao_Paulo/O=Dis/CN=localhost"

# Update system and install basic packages
RUN apt update && \
    apt upgrade -y && \
    apt install libzip-dev -y && \
    apt install wget -y && \
    apt install unzip -y && \
    apt install vim -y

# Install PHP extensions
RUN docker-php-ext-install zip pdo_mysql

# Install and configure XDebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.log=/var/www/html/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# PHP configuration file
COPY ./config/container/php/php.ini /usr/local/etc/php/

# Install composer
COPY ./config/container/php/install-composer.sh ./

RUN apt purge -y g++ \
    && apt autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/* \
    && sh ./install-composer.sh \
    && rm ./install-composer.sh \
    && composer global require friendsofphp/php-cs-fixer

ENV PATH="${PATH}:/root/.composer/vendor/bin"

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g sass typescript

# Root work directory
WORKDIR /var/www/html/public

# Start apache with container
CMD [ "apache2-foreground" ]
