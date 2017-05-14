#!/bin/sh

php_fpm_container_id=$(docker ps | grep php71-fpm | cut -f 1 -d ' ')
docker exec -u luqo33 ${php_fpm_container_id} ls -al
docker exec -u luqo33 ${php_fpm_container_id} composer install
