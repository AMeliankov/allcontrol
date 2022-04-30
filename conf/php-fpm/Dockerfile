FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libzip-dev \
      zip unzip \
      libpng-dev \
      libgd-dev \
      git && \ 
      docker-php-ext-install calendar && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install zip && \
      docker-php-ext-install exif && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-configure gd \
      --with-freetype=/usr/include/ \ 
      --with-jpeg=/usr/include/

RUN docker-php-ext-install gd

WORKDIR /var/www/

COPY ./conf/php-fpm/php.ini /usr/local/etc/php/conf.d/php.ini