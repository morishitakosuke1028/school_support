FROM php:8.1.6-fpm
COPY php.ini /usr/local/etc/php/

RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim \
libpng-dev \
libjpeg-dev \
libfreetype6-dev \
libzip-dev \
&& docker-php-ext-configure gd --with-jpeg --with-freetype \
&& docker-php-ext-install pdo_mysql bcmath gd zip \
&& docker-php-ext-install -j$(nproc) gd


# nodejs install
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Composer install
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
WORKDIR /var/www
RUN composer global require "laravel/installer"
