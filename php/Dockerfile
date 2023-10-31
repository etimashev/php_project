FROM php:8.2-fpm

RUN apt update && apt install --no-install-recommends --no-install-suggests -y \
    curl \
    libpng-dev \
    libonig-dev \
    libpq-dev

RUN docker-php-ext-install pgsql \
    pdo_pgsql \
    opcache

RUN pecl install \
    redis

RUN docker-php-ext-enable \
    redis

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

RUN chown www:www /var/www

USER www

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
