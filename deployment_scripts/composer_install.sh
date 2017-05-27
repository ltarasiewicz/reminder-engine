#!/bin/sh

php_container=$(docker ps | grep php71-fpm | cut -f 1 -d ' ')
docker exec -u $(id -u $USER) ${php_container} composer install --no-dev --optimize-autoloader --no-scripts
