#!/bin/sh

php_fpm_container_id=$(docker ps | grep php-fpm | cut -f 1 -d ' ')
docker exec ${php_fpm_container_id} composer install
