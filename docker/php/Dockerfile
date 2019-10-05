FROM php:7.3.10-fpm

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bcmath sockets

RUN apt-get update && apt-get install -y wget git unzip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www/html/