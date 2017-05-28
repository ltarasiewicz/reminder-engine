#!/bin/bash

echo "Run 'php app/console $*' on php-fpm-alpine";
docker exec -it -u $(id -u $USER)  php-reminder-engine sh -c "cd /var/www/html && php bin/console $*"
