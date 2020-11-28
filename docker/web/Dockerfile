FROM php:7.3-apache

RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update

RUN apt-get install -y vim less

# (2)
RUN set -ex apk --no-cache add postgresql-dev libpq-dev
RUN apt-get install -y libpq-dev \
 && docker-php-ext-install pdo pdo_pgsql pgsql mbstring

COPY ./php.ini /usr/local/etc/php/