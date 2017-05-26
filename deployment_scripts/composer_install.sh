#!/bin/sh

php_container=$(docker ps | grep php71-fpm | cut -f 1 -d ' ')
docker exec -u luqo33 ${php_container} composer install --no-dev --optimize-autoloader
