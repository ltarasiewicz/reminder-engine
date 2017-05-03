FROM ltarasiewicz/php-fpm-alpine-sf-dev:v0.1

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install app dependencies
COPY composer.json /var/www/html
RUN composer install

# Bundle app source
COPY . /var/www/html
