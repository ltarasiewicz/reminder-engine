#!/bin/sh

php_container=$(docker ps | grep php-reminder-engine | cut -f 1 -d ' ')
docker exec -u $(id -u $USER) ${php_container} rm -rf web/bundles/
