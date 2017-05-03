FROM ltarasiewicz/php-fpm-alpine-sf-dev:v0.1

WORKDIR /var/www/html

# Install app dependencies
COPY composer.json /var/www/html
RUN composer install

# Bundle app source
COPY . /var/www/html
