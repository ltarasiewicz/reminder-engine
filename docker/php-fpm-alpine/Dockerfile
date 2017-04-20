FROM php:7.1.3-fpm-alpine

COPY ./config/www-pool.conf /usr/local/etc/php-fpm.d/www.conf
#COPY ./scripts/download-composer.sh /root/download-composer.sh
#
#WORKDIR /root

#RUN chmod +x download-composer.sh \
#    && ./download-composer.sh \
#    && mv composer.phar /usr/local/bin/composer

RUN ["mkdir", "/var/log/php-fpm"]

RUN apk --update add \
      autoconf g++ make \
      openssl-dev \
      libxml2-dev \
    && pecl install \
        xdebug \
        mongodb \
    && docker-php-ext-enable \
        xdebug.so \
        mongodb.so \
    && docker-php-ext-install \
        pdo_mysql \
        soap \
    && apk del autoconf g++ make openssl-dev libxml2-dev \
    && rm -rf /var/cache/apk/*

### Configure xdebug

RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "xdebug.ide_key=PHPSTORM" >> /usr/local/etc/php/conf.d/php.ini

RUN addgroup sudo
RUN adduser -D luqo33 -G sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
