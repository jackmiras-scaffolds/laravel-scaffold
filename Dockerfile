FROM alpine:latest

LABEL Maintainer: Jack Miras

WORKDIR /var/www/html/

# Essentials
RUN echo "UTC" > /etc/timezone
RUN apk add --no-cache zip unzip curl sqlite supervisor

# Installing bash
RUN apk add bash
RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

# Installing NGINX
RUN apk add --no-cache nginx

# Instaling PHP
ADD https://dl.bintray.com/php-alpine/key/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub
RUN apk --update-cache add ca-certificates
RUN echo "https://dl.bintray.com/php-alpine/v3.11/php-7.4" >> /etc/apk/repositories

RUN apk add --no-cache php \
    php-common \
    php-fpm \
    php-opcache \
    php-zip \
    php-phar \
    php-curl \
    php-openssl \
    php-mbstring \
    php-json \
    php-xml \
    php-dom \
    php-sqlite3 \
    php-mysqli \
    php-redis

RUN ln -s /usr/bin/php7 /usr/bin/php

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Configure php-fpm
COPY .docker/php-fpm.conf /etc/php7/php-fpm.conf
COPY .docker/fastcgi-php.conf /etc/nginx/fastcgi-php.conf
RUN mkdir -p /run/php/ && touch /run/php/php7.4-fpm.pid

# Configure nginx
COPY .docker/nginx.conf /etc/nginx/conf.d/default.conf

RUN echo "daemon off;" >> /etc/nginx/nginx.conf
RUN mkdir -p /run/nginx/ && touch /run/nginx/nginx.pid

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

# Configure supervisor
RUN mkdir -p /etc/supervisor.d/
COPY .docker/supervisord.conf /etc/supervisor.d/supervisord.ini

# Building process
COPY . .
RUN composer install --no-dev

# Setting up permissions for Laravel storage
RUN chown -R nobody /var/www/html/storage

EXPOSE 80
CMD ["supervisord", "-c", "/etc/supervisor.d/supervisord.ini"]
