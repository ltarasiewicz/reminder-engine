#!/bin/bash

echo "Run 'php app/console $*' on php-fpm-alpine";
php_container=$(docker ps | grep php71-fpm | cut -f 1 -d ' ')
docker exec -it -u $(id -u $USER)  ${php_container} sh -c "cd /var/www/html && php bin/console $*"
docker exec ${php_container} sh -c "chown -R $(id -u ${USER}):www-data /var/www/html/var/cache && chmod -R g+w /var/www/html/var/cache"
