FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    librdkafka-dev \
    git \
    && docker-php-ext-install pdo pdo_mysql

RUN pecl install rdkafka \
    && docker-php-ext-enable rdkafka

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php-ini-overrides.ini /usr/local/etc/php/conf.d/php-overrides.ini
COPY . .

RUN composer install

EXPOSE 8008

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8008"]
