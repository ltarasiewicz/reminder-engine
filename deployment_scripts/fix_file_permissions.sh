#!/bin/sh

php_container=$(docker ps | grep php71-fpm | cut -f 1 -d ' ')
docker exec ${php_container} chown -R :www-data /var/www/html
