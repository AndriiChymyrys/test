FROM php:8.1-fpm-alpine

ARG UID
RUN if [ -z "$UID" ]; then echo "Build argument 'UID' was not set" 1>&2 && exit 1; fi

RUN echo "dev:x:$UID:$UID::/home/dev:" >> /etc/passwd \
    && echo "dev:!:$(($(date +%s) / 60 / 60 / 24)):0:99999:7:::" >> /etc/shadow \
    && echo "dev:x:$UID:" >> /etc/group \
    && mkdir /home/dev && chown dev: /home/dev

RUN apk add --no-cache libmcrypt libmcrypt-dev libxml2-dev git openssh-client openssh g++ make autoconf \
    fcgi pcre-dev postgresql-dev icu-dev freetype-dev libjpeg-turbo-dev libpng-dev libzip-dev zip gmp-dev \
    rabbitmq-c-dev

RUN pecl install xdebug \
    && pecl install apcu amqp-1.11.0beta \
    && docker-php-ext-enable apcu amqp \
    && { \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=4000'; \
        echo 'opcache.revalidate_freq=0'; \
        echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/10-docker-php-ext-opcache.ini \
    && { \
        echo 'xdebug.mode=develop,debug'; \
        echo 'xdebug.client_host=host.docker.internal'; \
        echo 'xdebug.start_with_request=yes'; \
        echo 'xdebug.idekey=PHPSTORM'; \
        } > /usr/local/etc/php/conf.d/99-docker-php-ext-xdebug.ini \
    && docker-php-ext-configure gd \
       --with-freetype=/usr/include/ \
       --with-jpeg=/usr/include/ \
    && docker-php-ext-enable opcache --ini-name 10-docker-php-ext-opcache.ini \
    && docker-php-ext-enable xdebug --ini-name 99-docker-php-ext-xdebug.ini \
    && docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) pdo_pgsql intl exif gd zip bcmath gmp

# Remove development packages.
RUN apk del --rdepends g++ make autoconf pcre-dev && rm -rf /tmp/* /var/tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www

ENV PATH="/var/www/vendor/bin:/var/www/bin:${PATH}"

USER dev

CMD ["php-fpm"]
