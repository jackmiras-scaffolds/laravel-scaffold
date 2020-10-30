FROM debian:buster-slim

LABEL Maintainer: Jack Miras

WORKDIR /var/www/html/

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8
ENV DEBIAN_FRONTEND="noninteractive"

# Setting up locale
RUN apt-get update \
    && apt-get install -y locales locales-all \
    && locale-gen en_US.UTF-8

# Essentials
RUN apt-get update -y && apt-get install -y lsb-release \
    apt-transport-https \
    ca-certificates \
    zip \
    wget \
    curl \
    unzip \
    nginx \
    sqlite3 \
    supervisor

# Instaling PHP
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list

RUN apt-get update -y && apt-get install -y php7.4-common \
    php7.4-fpm \
    php7.4-mbstring \
    php7.4-mysql \
    php7.4-sqlite3 \
    php7.4-xml \
    php7.4-curl \
    php7.4-zip \
    php7.4-json \
    php7.4-cli \
    php7.4-readline \
    php7.4-gd \
    php7.4-imap \
    php7.4-xdebug \
    php-igbinary \
    php-mongodb \
    php-redis

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Configure php-fpm
COPY .docker/php-fpm.conf /etc/php/7.4/fpm/php-fpm.conf

# Configure nginx
COPY .docker/nginx.conf /etc/nginx/conf.d/default.conf

RUN echo "daemon off;" >> /etc/nginx/nginx.conf
RUN mkdir -p /run/nginx/ && touch /run/nginx/nginx.pid

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

# Configure supervisor
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Cleaning up image
RUN apt-get remove -y --purge software-properties-common \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Building process
COPY . .
RUN composer install --no-dev

EXPOSE 80
CMD ["supervisord", "-c", "/etc/supervisor.d/supervisord.ini"]