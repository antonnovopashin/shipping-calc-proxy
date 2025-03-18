FROM composer:2.2.6 as composer
FROM php:7.4.3-fpm-alpine3.11
RUN docker-php-ext-install pdo pdo_mysql
# Copy the php config file
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Copy the application code
COPY . /app
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
VOLUME ["/app"]