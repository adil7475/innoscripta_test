# docker/php/Dockerfile
FROM php:8.1-fpm

RUN apt-get update
RUN apt-get install -y openssl zip unzip curl
RUN apt-get install -y libzip-dev libonig-dev libicu-dev
RUN apt-get install -y autoconf pkg-config libssl-dev

RUN docker-php-ext-install bcmath mbstring intl opcache

RUN docker-php-ext-install pdo pdo_mysql mysqli
