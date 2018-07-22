FROM php:7.1-fpm

# PHP extensions

RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client \
  && docker-php-ext-install mcrypt pdo_mysql \
  && docker-php-ext-install bcmath

WORKDIR /var/www
