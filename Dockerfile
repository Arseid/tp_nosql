FROM composer:latest AS composer

FROM php:apache

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

ADD ./src .

ADD ./index.php .

RUN apt update && apt install zip unzip git libcurl4-openssl-dev pkg-config libssl-dev -y && apt upgrade -y

RUN pecl install mongodb && docker-php-ext-enable mongodb && pecl config-set php_ini /usr/local/etc/php/php.ini
 
RUN composer require mongodb/mongodb && composer dump-autoload

