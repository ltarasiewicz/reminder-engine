#!/bin/bash

echo "Run 'composer #' in the php-fpm container";
php_container=$(docker ps | grep php71-fpm | cut -f 1 -d ' ')
docker exec -u $(id -u $USER)  ${php_container} sh -c "composer $*"
