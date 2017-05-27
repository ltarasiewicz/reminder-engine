FROM php:7.1.3-fpm-alpine

COPY ./config/www-pool.conf /usr/local/etc/php-fpm.d/www.conf

RUN apk add unzip python-dev --update
RUN curl -O https://bootstrap.pypa.io/get-pip.py
RUN python get-pip.py && pip install awscli
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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
RUN adduser -D default -G sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

VOLUME ["/var/log/php-fpm"]
ENTRYPOINT ["/entrypoint.sh"]

CMD ["php-fpm"]
