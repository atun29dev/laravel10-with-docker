FROM php:8.2-fpm-alpine

ARG TZ
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer

RUN set -eux && \
  apk add --update-cache --no-cache --virtual .build-dependencies tzdata && \
  apk add --no-cache zlib-dev libzip-dev libpng-dev icu-dev && \
  cp /usr/share/zoneinfo/${TZ} /etc/localtime && \
  apk del .build-dependencies && \
  docker-php-ext-install bcmath pdo pdo_mysql gd zip intl && \
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
