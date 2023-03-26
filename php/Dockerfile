FROM php:8.1-fpm-alpine

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install pdo pgsql

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli