FROM php:8.2-fpm-alpine3.21

ARG APP_ENV
RUN apk add --no-cache git

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions zip pdo pdo_pgsql bcmath @composer; \
    rm /usr/local/bin/install-php-extensions;

WORKDIR /app
