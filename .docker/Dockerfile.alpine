FROM alpine:edge

WORKDIR /var/www/html/

# Essentials
RUN echo "UTC" > /etc/timezone
RUN apk add --no-cache zip unzip curl sqlite nginx supervisor

# Installing bash
RUN apk add bash && sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

# Installing PHP
RUN apk add --no-cache php \
    php-common \
    php-fpm \
    php-pdo \
    php-opcache \
    php-zip \
    php-phar \
    php-iconv \
    php-cli \
    php-curl \
    php-openssl \
    php-mbstring \
    php-tokenizer \
    php-fileinfo \
    php-json \
    php-xml \
    php-xmlwriter \
    php-simplexml \
    php-dom \
    php-sqlite3 \
    php-pdo_mysql \
    php-tokenizer \
    php7-pecl-redis

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm -rf composer-setup.php

# Configure php-fpm
COPY .docker/php-fpm.conf /etc/php7/php-fpm.conf
COPY .docker/fastcgi-php.conf /etc/nginx/fastcgi-php.conf
RUN mkdir -p /run/php/ && touch /run/php/php7.4-fpm.pid

# Configure nginx
COPY .docker/nginx.conf /etc/nginx/conf.d/default.conf

RUN echo "daemon off;" >> /etc/nginx/nginx.conf \
    && mkdir -p /run/nginx/ && touch /run/nginx/nginx.pid \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

# Configure supervisor
RUN mkdir -p /etc/supervisor.d/
COPY .docker/supervisord.conf /etc/supervisor.d/supervisord.ini

# Building process
COPY . .
RUN composer install --no-dev

EXPOSE 80
CMD ["supervisord", "-c", "/etc/supervisor.d/supervisord.ini"]
